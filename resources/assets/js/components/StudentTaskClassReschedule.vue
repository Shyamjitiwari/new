<template>
   <div>
       <h3 style="color:black">Class reschedule</h3>
       <div class="row">
           <div class="col-4">
               <p>Student Name: {{student.full_name}}</p>
               <p>Class: {{taskclass.name}}</p>
               <p>Scehduled : {{taskclass.starts_at}}</p>
           </div>
           <div class="col"></div>
       </div>
       <hr>
       <div class="row">
           <div class="col">
               <form id="createLead" @submit.prevent="requestReschedule()">
                   <label>Select any class:</label>
                   <div class="row">
                       <div class="col-md-6" v-for="taskClass in taskClasses">
                           <div class="form-group">
                               <input type="radio" :value="taskClass" :id="taskClass.id" v-model="reschedule.selectedTaskClass" class="" required/>&nbsp;&nbsp;
                               <label>
                                   {{taskClass.name}} - {{taskClass.new_starts_at}} - {{taskClass.new_ends_at | timeOnly}}<br>
                                   Teacher: <span v-if="taskClass.class_teacher == 'Un assigned'">Un Assigned</span>
                                   <span v-else>{{taskClass.class_teacher.full_name}}</span>
                               </label>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Additional details: <span class="text-danger">*</span></label>
                               <textarea type="datetime-local" v-model="reschedule.description" class="form-control" required/>
                           </div>
                       </div>
                   </div>
                   <small>Please note that the current class will be cancelled immediately!</small><br>
                   <button type="submit" class="btn btn-primary" v-if="!loading"> Submit </button>
                   <loader-button bg="btn-dark text-white" title="Processing..." v-else> </loader-button>
               </form>
           </div>
       </div>
   </div>
</template>

<script>
    export default {
        props : ['student', 'taskclass'],
        data(){
            return {
                loading : false,
                reschedule : {
                    selectedTaskClass : null
                },
                taskClasses : []
            }
        },
        created() {
            this.getAvailableGroupTaskClasses()
        },
        methods : {
            requestReschedule()
            {
                let _this = this;
                _this.loading = true;
                axios.post('/parent/reschedule/store', {
                    'student' : _this.student,
                    'reschedule' : _this.reschedule,
                    'taskclass' : _this.taskclass,
                }).then(function(response) {
                    _this.loading = false;
                    window.location = '/parent/calendar';
                })
            },
            getAvailableGroupTaskClasses()
            {
                let _this = this;
                axios.post('/parent/reschedule/get-available-classes', {
                    'student' : _this.student,
                    'taskclass' : _this.taskclass,
                }).then(function(response) {
                    _this.taskClasses = response.data.taskClasses;
                })
            },
            getAvailablePrivateTaskClasses()
            {
            }
        }
    }
</script>
