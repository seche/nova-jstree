<template>
    <span>{{ field.value }}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    mounted(){
        let results = []
        // select fields from data that match what is saved in DB
        for (let i = 0; i < this.field.core.data.length; i++){
            for (let j = 0; j < this.field.value.length; j++){
                if(this.field.core.data[i]['id'].substring(this.field.token.length) === this.field.value[j]['id'].substring(this.field.token.length))
                    results.push(this.field.core.data[i]['text'])
            }
        }
        this.field.value = results.join(', ')
    },
}
</script>
