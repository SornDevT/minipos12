<template>
  <div class=" py-4">
    <nav aria-label="...">
      <ul class="pagination justify-content-end mb-0">
        <li class="page-item" v-bind:class="[back ? 'disabled' : '']">
          <a
            class="page-link"
            href="javascript:void(0)"
            tabindex="-1"
            v-on:click.prevent="changePage(pagination.current_page - 1)"
          >
            <i class="fas fa-angle-left"></i>
            <span class="sr-only"> <i class='bx bx-chevron-left' ></i> </span>
          </a>
        </li>
        <li
          class="page-item"
          v-for="page in pagesNumber"
          :key="page"
          :class="{ active: page == pagination.current_page }"
        >
          <a
            class="page-link"
            href="javascript:void(0)"
            v-on:click.prevent="changePage(page)"
            >{{ page }}</a
          >
        </li>
        <li class="page-item" v-bind:class="[next ? 'disabled' : '']">
          <a
            class="page-link"
            href="javascript:void(0)"
            v-on:click.prevent="changePage(pagination.current_page + 1)"
          >
            <i class="fas fa-angle-right"></i>
            <span class="sr-only"> <i class='bx bx-chevron-right'></i> </span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>
<script>
export default {
  data() {
    return {
      back: "disabled",
      next: "",
    };
  },
  props: {
    pagination: {
      type: Object,
      required: true,
    },
    offset: {
      type: Number,
      default: 4,
    },
  },
  computed: {
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }
      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      let to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }
      return pagesArray;
    },
  },
  methods: {
    changePage(page) {
      this.pagination.current_page = page;
      this.$emit("paginate",page);
      if (this.pagination.current_page > 1) {
        this.back = "";
      } else {
        this.back = "disabled";
      }
      if (this.pagination.current_page < this.pagination.last_page) {
        this.next = "";
      } else {
        this.next = "disabled";
      }
    },
  },
};
</script>
