<template>
    <panel-item :field="field">
    <span slot="value">
      <div :id="'jstree_' + field.token" :theme="field.theme"></div>
    </span>
    </panel-item>
</template>

<script>
window.jstree = require('jstree/dist/jstree');

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    mounted(){
        let jstreeId = '#jstree_' + this.field.token

        $(jstreeId).jstree({
            core: {
                themes : this.field.theme,
                data:  this.field.core.data,
            },
            "plugins" : [
                "changed",
                "search",
                "state",
                'types',
            ],
            "types" : this.field.types,
            'search' : this.field.search,
        });

        $(jstreeId).on('ready.jstree', () => {
            this.selections();
        });
    },
    methods: {
        selections(){
            let jstreeId = '#jstree_' + this.field.token

            $(jstreeId).jstree(true).hide_all();

            // select fields that match what is saved in DB
            for (let i = 0; i < this.field.value.length; i++){
                if(this.field.value[i]['state']['selected']){
                    $(jstreeId).jstree(true).show_node( this.field.token + this.field.value[i]['id'].substring(this.field.token.length));
                }
            }
        },
    },
}
</script>
