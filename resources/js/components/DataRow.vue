<template>
    <div>
      <code>query: {{ query }}</code>
      <datatable v-bind="$data" />
    </div>
  </template>
  <script>

  export default {
    props: {items: Array},
    mounted() {
        this.data = this.items;
    },
    data: () => ({
      columns: [
        { title: 'User name', field: 'user_name', sortable: true },
        { title: 'Oszlop', field: 'changedcolumn', sortable: true },
        { title: 'Adat', field: 'changeddata', sortable: false },
        { title: 'Változott', field: 'created_at', sortable: false },
      ],
      data: [],
      total: 0,
      query: {},
    }),

  }
  </script>
