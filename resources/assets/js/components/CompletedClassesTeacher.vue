<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3>
                            Completed Classes
                            <small class="float-right"><a class="btn btn-warning" title="View completed classes" :href="'/edit_teacher_profile/'+teacher_id">Back</a></small>
                        </h3>
                        <div class="text-bolder">Total Completed Task Classes: <b class="text-success">{{completedTaskClasses.completed_taskclasses_count}}</b></div>
                        <div class="text-bolder">Total Absent Task Classes: <b class="text-danger">{{completedTaskClasses.absent_taskclasses_count}}</b></div>
                        <table class="table" id="table1">
                            <thead>
                            <tr>
                                <td>Name</td>
                                <td>Time</td>
                                <td>Completed/Absent</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="taskClass in completedTaskClasses.classes" :key="taskClass.id">
                                <td>{{taskClass.name}}</td>
                                <td>{{taskClass.starts_at}} - {{taskClass.ends_at | timeOnly}}</td>
                                <td>
                                    <span class="text-success">{{taskClass.pivot.completed ? 'Completed' : ''}}</span>
                                    <span class="text-danger">{{taskClass.pivot.absent ? 'Absent' : ''}}</span>
                                </td>
                                <td>
                                    <button v-if="!taskClass.pivot.absent" class="btn btn-warning" @click="markAsIncomplete(taskClass.pivot.id)">Mark As Incomplete</button>
                                    <mark-absent v-if="!taskClass.pivot.completed" :pivot="taskClass.pivot" @postUpdate="getCompletedTaskClasses"></mark-absent>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['teacher_id'],
        data(){
            return {
                completedTaskClasses : []
            }
        },
        methods:{
            getCompletedTaskClasses(){
                var _this = this;
                axios.post('/get-completed-assigned-classes-teacher',{'teacher_id':_this.teacher_id}).then(function(response){
                    _this.completedTaskClasses = response.data.completedClasses;
                })
            },
            markAsIncomplete(pivot_id){
                if(confirm('Are you sure you want to mark this class as incomplete?'))
                {
                    let _this = this;
                    axios.post('/teacher/mark-task-class-incomplete', {'id':pivot_id}).then(function(response){});
                    this.getCompletedTaskClasses();
                }
            }
        },
        created(){
            this.getCompletedTaskClasses();
        }
    }
</script>
