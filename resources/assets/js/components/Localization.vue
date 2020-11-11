<template>
    <div>
        <div class="row">
            <div class="col-md-12 ">
                <div v-show="dataUpdated">
                    <h5 style="color:green">String has been updated.</h5>
                </div>
                <form v-show="updateDataForm" @submit.prevent="updateData" enctype="multipart/form-data">
                    <h3>Update String</h3>
                    <input type="hidden" class="form-control" v-model="locale.locale_file"/>
                    <div class="form-group">
                        <label>Key</label>
                        <input type="text" class="form-control" v-model="locale.string_key" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Value</label>
                        <input type="text" class="form-control" v-model="locale.string_value" required/>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Update" />
                    <button class="btn btn-danger" type="button" @click="reset" >Reset</button>
                </form><br/><br/>

                <form @submit.prevent="getLocalizedStrings" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select a Locale</label>
                                <select  class="option form-control" @change="onChangeOfLocale($event)" v-model="selectedValueOfLocale" required>
                                    <option v-for="locale in locales" v-bind:key="locale.id" :value="locale.id"> {{ locale.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select a Project</label>
                                <select  class="option form-control" @change="onChangeOfProject($event)" v-model="selectedValueOfProject" required>
                                    <option v-for="project in projects" v-bind:key="project.id" :value="project.id"> {{ project.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"> Get Localized Strings </button>
                </form>
                <br/><br/>
                <div v-show="isLocaleSelected">
                    <h3>Locale Strings</h3>
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <td><b>String Key</b></td> 
                                <td><b>String Value</b></td>
                                <td><b>File</b></td>      
                                <td></td>        
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="localizedString in localizedStrings" v-bind:key="localizedString.locale_file+localizedString.string_key">
                               <td>{{ localizedString.string_key }}</td>
                               <td>{{ localizedString.string_value }}</td>
                               <td>{{ localizedString.locale_file }}</td>
                               <td><button @click="editData(localizedString)" class="btn btn-warning">EDIT</button></td>
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
                isLocaleSelected : false,
                updateDataForm : false,
                dataUpdated : false, 
                locales : [],
                projects : [],
                localizedStrings : [],
                selectedValueOfLocale : '',
                selectedValueOfProject : '',
                locale : {locale : '', project : '',locale_file :'', string_key: '', string_value: ''},
            }
        },
        methods:{
            getLocales(){
                var _this = this;
                axios.get('/get_locales').then(function(response){
                    _this.locales = response.data.locales; 
                })
            },
            getProjects(){
                var _this = this;
                axios.get('/get-projects-for-locales').then(function(response){
                    _this.projects = response.data.projects; 
                })
            },
            onChangeOfLocale(e){
                this.locale.locale = event.target.value;
                this.selectedValueOfLocale = event.target.value; 
                this.updateDataForm = false;
                this.dataUpdated = false; 
            },
            onChangeOfProject(e){
                this.locale.project = event.target.value;
                this.selectedValueOfProject = event.target.value; 
                this.updateDataForm = false;
                this.dataUpdated = false; 
            },
            getLocalizedStrings(e){
                var _this = this;
                axios.post('/get_localized_strings', _this.locale).then(function(response){
                    _this.isLocaleSelected = true; 
                    _this.localizedStrings = response.data.localized_strings;
                })
            },
            editData(localizedString){
                var _this = this;
                _this.updateDataForm = true;
                _this.dataUpdated = false;
                _this.locale.locale_file = localizedString.locale_file;
                _this.locale.string_key = localizedString.string_key;
                _this.locale.string_value = localizedString.string_value;
            }, // End of Edit Data Method
            updateData(){
                var _this = this;
                axios.post('/edit_locale_string', _this.locale).then(function(response){
                    _this.updateDataForm = false;
                    _this.dataUpdated = true;
                    _this.getLocalizedStrings();
                })
            },
            reset(){
                var _this = this;
                _this.updateDataForm = false;
                _this.dataUpdated = false;
                _this.locale.locale_file = "";
                _this.locale.string_key = "";
                _this.locale.string_value = "";
            },
        },
        created(){
            this.getLocales();
            this.getProjects();
        }
    }
</script>
