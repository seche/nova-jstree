<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template slot="field">
        <input
            :id="field.attribute"
            type="hidden"
            :class="errorClasses"
            v-model="value"
        />
        <div class="flexContainer mb-2" v-if="field.openCloseAllBtns.visible">
            <button
                :id="'jstree_open_all_btn_' + field.token"
                class="btn btn-default btn-primary"
                type="button"
                v-text="openAllButtonText"
            ></button>
            <button
                :id="'jstree_close_all_btn_' + field.token"
                class="btn btn-default btn-primary"
                type="button"
                v-text="closeAllButtonText"
            ></button>
        </div>
        <div class="flexContainer mb-2" v-if="field.search.visible">
            <input
                :id="'jstree_search_' + field.token"
                type="text"
                class="w-full form-control form-input form-input-bordered"
                :class="errorClasses"
                :placeholder="__('Search Placeholder')"
            />
            <button
                :id="'jstree_search_btn_' + field.token"
                class="btn btn-default btn-primary"
                type="button"
                v-text="addButtonText"
            ></button>
        </div>
        <div :id="'jstree_' + field.token" :theme="field.theme"></div>
        <p v-if="hasError" class="my-2 text-danger">
            {{ firstError }}
        </p>
    </template>
  </default-field>
</template>

<script>
window.jstree = require('jstree/dist/jstree');

import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    mounted(){
        let jstreeId = '#jstree_' + this.field.token
        let jstreeSearchId = '#jstree_search_' + this.field.token

        $(jstreeId).jstree({
            core: {
                themes : this.field.theme,
                data:  this.field.core.data,
            },
            "plugins" : [
                "changed",
                "checkbox",
                "search",
                "state",
                'types',
            ],
            "types" : this.field.types,
            'search' : this.field.search,
            'checkbox' : this.field.checkbox,
        });

        /**
         * Search Nodes on key up
         */
        let to = false
        $(jstreeSearchId).keyup(function (){
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                let v = $(jstreeSearchId).val();
                $(jstreeId).jstree(true).search(v);
            }, 250);
        });

        /**
         * Select nodes from search results on Enter Key
         */
        $(jstreeSearchId).keydown( () => {
            if(event.key === 'Enter') {
                // enter return key
                event.preventDefault(); // cancel submit form
                this.selectResults();
            }
        });

        /**
         * Select nodes from search results
         */
        $('#jstree_search_btn_' + this.field.token).mousedown( () => {
            this.selectResults();
        });

        /**
         * Close all nodes
         */
        $('#jstree_close_all_btn_' + this.field.token).mousedown( () => {
            $(jstreeId).jstree(true)
                .close_all();
        });

        /**
         * Open all nodes
         */
        $('#jstree_open_all_btn_' + this.field.token).mousedown( () => {
            $(jstreeId).jstree(true)
                .open_all();
        });

        /**
         * update selections once tree is changed
         */
        $(jstreeId).on("changed.jstree", (e, data) => {
            this.value = JSON.stringify($(jstreeId).jstree("get_selected", true));
        });

        /**
         * Set selections once tree is ready
         */
        $(jstreeId).on('ready.jstree', () => {
            this.selections();
        });

    },

    methods: {
        /**
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(
                this.field.attribute,
                this.value || ''
            );
        },

        /**
         * Check / select nodes
         */
        selections(){
            if(this.field.value != null){
                let jstreeId = '#jstree_' + this.field.token
                // select fields that match what is saved in DB
                for (let i = 0; i < this.field.value.length; i++){
                    if(this.field.value[i]['state']['selected']){
                        $(jstreeId).jstree(true).check_node( this.field.token + this.field.value[i]['id'].substring(this.field.token.length));
                    }
                }
            }
        },

        /**
         * Update field value with selected nodes
         */
        selectResults(){
            let jstreeId = '#jstree_' + this.field.token
            let jstreeSearchId = '#jstree_search_' + this.field.token
            let searchResult = $(jstreeId).jstree('search', $(jstreeSearchId).val());

            searchResult = $(searchResult).find('.jstree-search')
            for (let i = 0; i < $(searchResult).length; i++) {
                $(jstreeId).jstree(true).select_node($( "#" + $(searchResult)[i].id).parent())
            }
        },
    },

    computed: {
        addButtonText() {
            return this.field.searchBtn || 'Add Search Results';
        },
        openAllButtonText() {
            return this.field.openAllBtn || 'Open All';
        },
        closeAllButtonText() {
            return this.field.closeAllBtn || 'Close All';
        },
    },
}
</script>
