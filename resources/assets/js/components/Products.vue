<template>
  <div class="container-fluid mt-5">
    <div id="" class="row">
      <div class="col-sm-3 mb-3 px-4">
        <h4 class="mb-3">Product details</h4>
        <form @submit.prevent="addProduct">
          <div class="form-group">
            <label>Product name</label>
            <input type="text" class="form-control" v-model="product.product_name">
          </div>
          <div class="form-group">
              <label>Description</label>
              <textarea v-model="product.description" class="form-control" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-dark btn-block">Save</button>
        </form>
      </div>
      <div class="col-sm-9">

          <h4 class="mb-3">Product list</h4>


        <div class="row">
          <div class="col-sm-4 mb-4" v-for="product in products" :key="products.id">
            <div class="card">
              <div class="card-header">
                {{ product.product_name }}
              </div>
              <!-- <img class="card-img-top" src="https://bulma.io/images/placeholders/128x128.png" alt="Card image cap"> -->
              <div class="card-body">
                <!-- <h5 class="card-title">{{ product.product_name }}</h5> -->
                <p class="card-text">{{ product.description }}</p>

                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" @click="editProduct(product)" class="btn btn-outline-warning">Edit</button>
                    <button type="button" @click="deleteProduct(product.id)" class="btn btn-outline-danger">Delete</button>
                  </div>
                  <small class="text-muted">9 mins</small>
                </div>

              </div>
            </div>
          </div>
        </div>
        <nav>
          <ul class="pagination justify-content-center">
            <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" @click="fetchProducts(pagination.prev_page_url)">Previous</a></li>

            <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

            <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" @click="fetchProducts(pagination.next_page_url)">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      products: [],
      product: {
        id: '',
        product_name: '',
        description: ''
      },
      product_id: '',
      pagination: {},
      edit: false
    }
  },

  created() {
    this.fetchProducts();
  },

  methods: {
    fetchProducts(page_url) {
      let vm = this;
      page_url = page_url || '/api/products'
      fetch(page_url)
          .then(res => res.json())
          .then(res => {
            this.products = res.data;
            vm.makePagination(res.meta, res.links)
          })
          .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };

      this.pagination = pagination;
    },
    deleteProduct(id) {
      if (confirm('Are you sure you want to delete?')) {
        fetch(`api/product/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Product remove');
            this.fetchProducts();
          })
          .catch(err => console.log(err))
      }
    },
    addProduct() {
      if (this.edit === false) {
        fetch('api/product', {
          method: 'post',
          body: JSON.stringify(this.product),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.product.product_name = '';
            this.product.description = '';
            alert('Product saved!');
            this.fetchProducts();
          })
          .catch(err => concole.log(err))
      } else {
        fetch('api/product', {
          method: 'put',
          body: JSON.stringify(this.product),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.product.product_name = '';
            this.product.description = '';
            alert('Product saved!');
            this.fetchProducts();
          })
          .catch(err => concole.log(err))
      }
    },
    editProduct(product) {
      this.edit = true;
      this.product.id = product.id;
      this.product.product_id = product.id;
      this.product.product_name = product.product_name;
      this.product.description = product.description;
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
