<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-b-30">
                <div class="card-header bg-white">
                    <h5 class="card-title text-black">Upcoming Tasks Classes</h5>
                    <h6 class="card-subtitle">A brief summary of the upcoming tasks classes for the next two weeks</h6>
                </div>
                <div v-if="upComingClasses.data.length" class="card-body">
                    <div class="accordion" id="accordionExample" >
                        <div class="card mb-2" v-for="(c, parent) in upComingClasses.data" :key="c.id">
                            <div class="card-header p-1" id="headingOne">
                                <h5 class="mb-0 text-secondary">
                                    <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" :data-target="'#collapseOne'+c.id" aria-expanded="false" aria-controls="collapseOne"><i class="icon-question text-primary mr-1"></i>
                                        {{c.name}} : {{c.starts_at }} - {{c.ends_at | timeOnly}}
                                    </button>
                                    <small style="float: right">( Students : {{c.students_count}} )</small>
                                </h5>
                            </div>
                            <div :id="'collapseOne'+c.id" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th class="border-top-0" width="5%">Sr.No</th>
                                                <th class="border-top-0">Student Name</th>
                                                <th class="border-top-0">Topic</th>
                                                <th class="border-top-0">Email</th>
                                                <th class="border-top-0">Mobile</th>
                                                <th class="border-top-0">Ping</th>
                                                <th class="border-top-0">Meet Link</th>
                                                <th class="border-top-0">Notes</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="(s, index) in c.students">
                                                <tr>
                                                    <td>{{++index}}</td>
                                                    <td class="text-capitalize">{{s.user_name}}</td>
                                                    <td class="text-capitalize">
                                                        <span v-if="s.topics.length">{{s.topics[0].name}}</span>
                                                        <span v-else>-</span>
                                                        <i class="fa fa-pencil text-success" title="Change Student's Topic"
                                                           @click="showTopics = !showTopics; currentIndex = index+parent"></i>
                                                        <update-student-topic v-if="showTopics && currentIndex == index+parent " :student="s" @postTopicUpdate="postTopicUpdate"></update-student-topic>
                                                    </td>
                                                    <td>{{s.email}}</td>
                                                    <td>{{s.phone_number}}</td>
                                                    <td class="text-center"><ping-parents :student_id="s.id" style="cursor:pointer"> </ping-parents></td>
                                                    <td><a :href="s.classroom_link">{{s.classroom_link}}</a></td>
                                                    <td>
                                                        <span class="text-primary" style="cursor:pointer" v-if="s.notes" @click="student = s" data-toggle="modal" data-target="#notesModal">Click To View</span>
                                                        <span v-else>-</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="s.pivot.completed" class="text-success">Completed </span>
                                                        <span v-if="s.pivot.absent" class="text-danger"> Absent </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-warning" title="Generate/Refresh Meet Link" @click="refreshMeetLink(c.id,s.id)">Generate/Refresh Meet Link</button><br/><br/>
                                                        <button v-if="!s.pivot.absent && !s.pivot.completed" @click="markTaskClassAsCompleted(c.id, s)" class="btn btn-warning">Mark As Complete</button>
                                                        <mark-absent v-if="!s.pivot.absent && !s.pivot.completed" :pivot="{'id':s.pivot.id,'absent':s.pivot.absent, 'task_class_id' : c.id}" @postUpdate="postUpdate"> </mark-absent>
                                                        <button @click="updateStudentData(s)" data-toggle="modal" data-target="#studentUpdateModal2" title="SMS Update" class="btn btn-primary" id="studentsUpdate"><i class="icon-envelope"></i></button>
                                                    </td>  
                                                </tr>   
                                                <tr>
                                                    <td colspan="1"><h5>Latest Update</h5></td>
                                                    <td colspan="3">{{s.user_updates_dashboard ? s.user_updates_dashboard.content : '-'}}</td>
                                                    <td colspan="2"><h5>Feedback</h5></td>
                                                    <td colspan="3">{{s.latest_survey ? s.latest_survey.improvement : '-'}}</td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <pagination show=4 :data="upComingClasses" @updatePagination="updatePagination"> </pagination>
                </div>
                <div v-else class="card-body">No upcoming tasks classes for the next 2 weeks</div>
            </div>
        </div>

        <div v-if="showPopUp" style="position: fixed; top:20%; left: 35%; box-shadow: 0px 1px 8px 5px lightgrey; border-radius: 5px;width: 35%">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="close" @click="closePopUp">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <student-updates :student="student" @closeModal="closePopUp"> </student-updates>
                </div>
            </div>
        </div>

        <div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notesModalLabel">Notes for {{student.user_name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{student.notes}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                upComingClasses : [],
                pagination: {},
                students : [],
                student : {student_id : '', user_name : '', notes: ''},
                showPopUp : false,
                showTopics : false,
                currentIndex : ''
            }
        },
        created()
        {
            this.getUpcomingClasses();
            this.getTopics();
        },
        methods: {
            postTopicUpdate(){
                this.showTopics = false;
                this.getUpcomingClasses();
            },
            postUpdate(task_class_id){
                this.getUpcomingClasses();
            },
            updateStudentData(student){
                this.showPopUp = !this.showPopUp;
                this.student = student;
                this.student.student_id = student.id;
            },
            closePopUp(){
                this.showPopUp = false;
            },
            markTaskClassAsCompleted(task_class_id, student)
            {
                if(confirm('Before marking this as complete, did you write an update for this student’s parents? If not, press cancel and use the little mailbox icon to write an update for the student’s parent. If you did write an update, press OK to mark class as complete.'))
                {
                    let _this = this;
                    axios.post('/teacher/mark-task-class-competed', {id:student.pivot.id}).then(function(response){});
                    this.getUpcomingClasses();
                }
            },
            getUpcomingClasses()
            {
                let _this = this;
                axios.get('/teacher/get-all-upcoming-classes?page='+_this.pagination.current_page).then(function(response) {
                    _this.upComingClasses = response.data.upComingClasses
                });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.getUpcomingClasses();
            },
            // getStudentsForTaskClass(id)
            // {
            //     let _this = this;
            //     axios.get('/get-all-student-for-task-class/' + id).then(function(response) {
            //         _this.students = response.data.taskClasses;
            //     });
            // },
            refreshMeetLink(classId, studentId){
                var _this = this;
                _this.student.student_id = studentId;
                axios.post('/create_google_meetlink_for_a_student', _this.student).then(function(response){
                    _this.getUpcomingClasses();
                })
            }
        }
    }
</script>