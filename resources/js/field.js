Nova.booting((Vue, router, store) => {
  Vue.component('index-jstree', require('./components/IndexField'))
  Vue.component('detail-jstree', require('./components/DetailField'))
  Vue.component('form-jstree', require('./components/FormField'))
})
