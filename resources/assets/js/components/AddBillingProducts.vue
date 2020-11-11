<template>
    <div>
        <div class="row">
            <div class="col-md-12 ">

                <form @submit.prevent="addData" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Billing Product Id <span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <input class="form-control" type="text" v-model="billing_product.product_id" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Billing Product Name <span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <input class="form-control" type="text" v-model="billing_product.product_name" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Description<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <input class="form-control" type="text" v-model="billing_product.description" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Frequency<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <select  class="option form-control" v-model="billing_product.frequency_id" required>
                                <option v-for="frequency in frequencies" v-bind:key="frequency.id" :value="frequency.id"> {{ frequency.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Price<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <input class="form-control" type="number" placeholder="1.0" step="0.01" min="0" v-model="billing_product.price" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Currency<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <select  class="option form-control" v-model="billing_product.currency_id" required>
                                <option v-for="currency in currencies" v-bind:key="currency.id" :value="currency.id"> {{ currency.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Number of credits<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                           <input class="form-control" type="number" placeholder="1.0" step="0.01" min="0"  v-model="billing_product.number_of_credits" required/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Is a Subscription<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                           <input type="checkbox" class="form-control" style="font-size: 4px;" id="customCheck1" v-model="billing_product.is_subscription">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Is a Promo<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                           <input type="checkbox" class="form-control" style="font-size: 4px;" id="customCheck2" v-model="billing_product.is_promo">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Password<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                           <input class="form-control" type="text" v-model="billing_product.password"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Select Location<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <select  class="option form-control" v-model="billing_product.location_id" required>
                                <option v-for="location in locations" v-bind:key="location.id" :value="location.id"> {{ location.location_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" >Task Class Type<span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <select  class="option form-control" v-model="billing_product.task_class_type_id" required>
                                <option v-for="taskClassType in taskClassTypes" v-bind:key="taskClassType.id" :value="taskClassType.id"> {{ taskClassType.type_name }}</option>
                            </select>
                        </div>
                    </div>
                     <div class="col-lg-12">
                        <input class="btn btn-primary" type="submit" value="Add New Class" />
                    </div>
                </form>
                <br/><br/>
               <h3>Billing Products</h3>
               <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td><b>Id</b></td> 
                                <td><b>Name</b></td>
                                <td><b>Description</b></td>  
                                <td><b>Frequency</b></td>     
                                <td><b>Price</b></td>
                                <td><b>Currency</b></td>
                                <td><b>No of Credits</b></td>
                                <td><b>Is Subscription</b></td>
                                <td><b>Is Promo</b></td>
                                <td><b>Password</b></td>  
                                <td colspan="3"><b>Location</b></td>
                                <td colspan="3"><b>Task Class Type</b></td>    
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="billingProduct in billingProducts" v-bind:key="billingProduct.id">
                               <td>{{ billingProduct.product_id }}</td>
                               <td>{{ billingProduct.product_name }}</td>
                               <td>{{ billingProduct.description }}</td>
                               <td>{{ billingProduct.frequency }}</td>

                               <td>{{ billingProduct.price }}</td>
                               <td>{{ billingProduct.currency }}</td>
                               <td>{{ billingProduct.number_of_credits }}</td>
                               <td>{{ billingProduct.is_subscription }}</td>

                               <td>{{ billingProduct.is_promo }}</td>
                               <td>{{ billingProduct.password }}</td>
                               <td>{{ billingProduct.location_name }}</td>
                                <td>{{ billingProduct.task_class_type_name }}</td>
                               <td><button @click="editData(billingProduct)" class="btn btn-warning">EDIT</button></td>
                               <td><button @click="deleteData(billingProduct.id)" class="btn btn-danger">DELETE</button></td>
                            </tr>
                        </tbody>
                    </table>
               </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                billingProducts : [],
                locations : [],
                taskClassTypes : [],
                frequencies : [],
                currencies : [],
                id : '',
                product_id : '',
                product_name : '',
                description : '',
                frequency : '',
                price : '',
                currency : '',
                number_of_credits : '',
                is_subscription : false,
                is_promo : false,
                password : '',
                location : '',
                task_class_type : '',
                edit : false,
                billing_product : { product_id : '', product_name : '', description : '',
                                    frequency_id : '', price : '', currency_id : '',
                                    number_of_credits : '', is_subscription : false,
                                    is_promo : false, password : '', location_id : '',
                                    task_class_type_id : '', },
            }
        },
        methods:{
            getData(){
                var _this = this;
                _this.getAllBillingProducts();
                _this.getLocations();
                _this.getTaskClassTypes();
                _this.getAllTaskClassFrequencies();
                _this.getAllCurrencies();
            },
            getAllBillingProducts(){
                var _this = this;
                axios.get('/get_all_billing_products').then(function(response){
                    debugger;
                    if(response.data.response_msg == "No Billing Products."){
                        //
                    }
                    else{
                        _this.billingProducts = response.data.billingProducts;
                    }
                })
            },  
            getLocations(){
                debugger;
                var _this = this;
                axios.get('/get-locations').then(function(response){
                    if(response.data.response_msg == "No Locations"){
                        //
                    }
                    else{
                        _this.locations = response.data.locations;
                    }
                })
            },
            getTaskClassTypes(){
                debugger;
                var _this = this;
                axios.get('/get-task-class-types').then(function(response){
                    if(response.data.response_msg == "No Task Class Types."){
                        //
                    }
                    else{
                        _this.taskClassTypes = response.data.task_class_types;
                    }
                })
            },
            getAllTaskClassFrequencies(){
                debugger;
                var _this = this;
                axios.get('/get_all_frequencies').then(function(response){
                    if(response.data.response_msg == "No Task Class Frequencies."){
                        //
                    }
                    else{
                        _this.frequencies = response.data.taskClassFrequencies;
                    }
                })
            },
            getAllCurrencies(){
                debugger;
                var _this = this;
                axios.get('/get_all_currencies').then(function(response){
                    if(response.data.response_msg == "No Currencies."){
                        //
                    }
                    else{
                        _this.currencies = response.data.currencies;
                    }
                })
            },
            addData(e){
                e.preventDefault();
                var _this = this;
                debugger;
                if(_this.edit == false){             
                    axios.post('/add_billing_product',_this.billing_product).then(function(response){
                        if(response.data.reponse_msg == "Billing Product cannot be added."){
                            alert("Billing Product cannot be added.");
                        }
                        else{
                            _this.billing_product = { product_id : '', product_name : '', description : '',
                                                      frequency_id : '', price : '', currency_id : '',
                                                      number_of_credits : '', is_subscription : false,
                                                      is_promo : false, password : '', location_id : '',
                                                      task_class_type_id : '', },
                            _this.getData();
                        }  
                    })              
                } 
                else{
                    axios.put('/billing_product/edit/'+_this.id,_this.billing_product).then(function(response){
                        _this.billing_product = { product_id : '', product_name : '', description : '',
                                                  frequency_id : '', price : '', currency_id : '',
                                                  number_of_credits : '', is_subscription : false,
                                                  is_promo : false, password : '', location_id : '',
                                                  task_class_type_id : '', };
                        _this.edit = false;
                        _this.getData(); 
                    })
                }
            },
            editData(billingProduct){
                debugger;
                var _this = this;
                _this.edit = true;
                _this.id = billingProduct.id;
                _this.product_id = billingProduct.product_id;
                _this.billing_product.product_id = billingProduct.product_id;
                _this.billing_product.product_name = billingProduct.product_name;
                _this.billing_product.description = billingProduct.description;
                _this.billing_product.frequency_id = billingProduct.frequency_id;

                _this.billing_product.price = billingProduct.price;
                _this.billing_product.currency_id = billingProduct.currency_id;
                _this.billing_product.number_of_credits = billingProduct.number_of_credits;
                _this.billing_product.is_subscription = billingProduct.is_subscription;

                _this.billing_product.is_promo = billingProduct.is_promo;
                _this.billing_product.password = billingProduct.password;
                _this.billing_product.location_id = billingProduct.location_id;
                _this.billing_product.task_class_type_id = billingProduct.task_class_type_id;
               
            }, // End of Edit Data Method
            deleteData(id){
                debugger;
                var _this = this;
                if(confirm('Are you sure?')){
                    axios.delete('/billing_product/delete/'+id).then(function(response){
                    _this.getData();
                 })
                }
            }, // End of Delete Data Method          
        },
        created() {
             this.getData();
        }
        
    }
</script>
