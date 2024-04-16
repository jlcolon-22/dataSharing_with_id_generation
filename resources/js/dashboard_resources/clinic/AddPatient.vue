<template>
    <div >
        <!-- Modal -->
        <div class="modal " id="addModal" data-bs-backdrop="static" data-bs-keyboard="false"   tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" >
                <form @submit.prevent="store" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Student Information</h5>
                        <button type="button" @click="$emit('close')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Student Info -->
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label fw-bold">First Name:</label> <br>
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.first_name}}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label fw-bold">Middle Name:</label> <br>
                                    <label for="recipient-name" class="col-form-label">{{userInfo.middle_name }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label fw-bold">Last Name:</label> <br>
                                    <label for="recipient-name" class="col-form-label">{{userInfo.last_name }}</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label fw-bold">Course:</label> <br>
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.course }}</label>
                                </div>
                            </div>
                        </div>
                        <!-- Guardian's Info -->
                        <h5 class="modal-title" id="exampleModalLabel">Guardian's Information</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label  fw-bold">Guardian's Name:</label>
                                    <br>
                                    <label for="recipient-name"  class="col-form-label">{{ userInfo.guardian_name }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-labe fw-bold ">Guardian's Address:</label>
                                    <br>
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.address }}</label>
                                </div>
                            </div>
                        </div>
                        <!-- Other Info -->
                        <div class="row">
                        </div>
                        <h5 class="modal-title " id="exampleModalLabel">Prescription</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label fw-bold">Vitals Sign:</label>
                                    <div class="row">
                                        <div class="col">
                                            Temperature
                                            <input type="number" v-model="state.temp" step="0.01" required="true"  class="form-control" id="temp-input">
                                        </div>
                                        <div class="col">
                                            Blood Pressure
                                            <input type="text" v-model="state.bp" required="true" class="form-control" id="bp-input">
                                        </div>
                                        <div class="col">
                                            Respiratory Rate
                                            <input type="number" v-model="state.rr" required="true" class="form-control" id="rr-input">
                                        </div>
                                        <div class="col">
                                            Pulse Rate
                                            <input type="number" v-model="state.pr" required="true" class="form-control" id="pr-input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label fw-bold">Chief Complaint</label>
                                    <textarea class="form-control" v-model="state.chief_complain" required="true" id="message-text"></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label fw-bold ">Management / Medication
                                        Given:</label>
                                    <textarea class="form-control" v-model="state.medication_given" required="true" id="message-text"></textarea>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-5 fw-bold">Student Health Details</h5>
                        <!-- the data input will display here -->
                        <div style="overflow: auto; max-height:300px; width: 100%;">
                            <table class="table  table-striped mt-3"  >
                            <thead >
                                <tr class="sticky-top" style="width: 100%;background: white;">
                                    <th>Date</th>
                                    <th>Vital Signs</th>
                                    <th>Chief Complaint</th>
                                    <th>Management / Medication Given:</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody  >
                                <!-- Loop through the entry items -->
                                <tr v-for="(entry, index) in medicalHistory" :key="index">
                                    <td>{{ moment(entry.created_at).format('MMM D YYYY') }}</td>
                                    <td>
                                        <p><strong>Temperature:</strong> {{ entry.temp }}°C</p>
                                        <p><strong>Blood Pressure:</strong> {{ entry.bp }}mmHg</p>
                                        <p><strong>Respiratory Rate:</strong> {{ entry.rr }}breaths/min</p>
                                        <p><strong>Pulse Rate:</strong> {{ entry.pr }}bpm</p>
                                    </td>
                                    <td>{{ entry.chief_complain }}</td>
                                    <td>{{ entry.medication_given }}</td>
                                    <td>
                                       <a type="button"
                             style="border: none;background: none;"  @click="$emit('openEdit',entry)" > <i class="fa-solid fa-pen-to-square" style="color: green; font-size: 25px;"></i></a>
                                        <button type="button" style="background: none; border: none;" @click="destroy(entry.id)"><i class="fa-solid fa-square-xmark"
                                            style="color: red; font-size: 25px; margin-left: .5rem;"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-success">Submit</button>
                        <button type="button" @click="$emit('close')" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script setup>
import { reactive, ref, toRef, watch } from "vue";
import axios from "axios";
import moment from "moment";

const props = defineProps(['userInfo','add'])
const active = toRef(props,'add')
const newProps = toRef(props,'userInfo');
const state = reactive({
    student_id:'',
    school_year_semester:'',
    student_name:'',
    section:'',
    temp:'',
    bp:'',
    rr:'',
    pr:'',
    chief_complain:'',
    medication_given:'',
})
const recordData = ref([]);
const medicalHistory = ref([]);


watch(props, async (newV,oldV) =>{
    console.log('sss')
    if(props.add)
    {
        state.student_id = newProps.value.student_no;
        state.school_year_semester = newProps.value.school_year_semester;
        state.student_name = `${newProps.value.first_name} ${newProps.value.middle_name} ${newProps.value.last_name}` ;

        await getStudentRecord()
    }
})

// add student record
const store = async () =>{
    await axios.post('/api/clinic/add/record',state);
    state.temp = '';
    state.bp = '';
    state.rr = '';
    state.pr = '';
    state.chief_complain = '';
    state.medication_given = '';
    await getStudentRecord()
}

const getStudentRecord = async () =>{
    const res = await axios.post('/api/clinic/student/record',{school_year_semester:state.school_year_semester,student_id:state.student_id})
    if(res.status == 200)
    {
        medicalHistory.value = res.data;
    }else{
        medicalHistory.value = [];
    }
}

// delete record
const destroy = async (id) =>{
    const {data} = await axios.delete('/api/clinic/delete/student/record/'+id);
    await getStudentRecord()
}
</script>
<style>
/* Modal Design */
.modal-header {
    background-color: rgb(95, 178, 95);
    color: #ffffff;
}

.modal-body h5 {
    color: rgb(67, 155, 67);
}

.modal-footer {
    background-color: #f8f9fa;
}</style>

