<template>
    <div>
      <!-- Modal -->
      <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content" >
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">View Patient Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="print-me" style="max-height: 600px;overflow: auto;">
              <!-- View Student Health History -->
              <div class="card">
                <div class="card-header">
                  View Student History Health Details
                </div>
                <div class="card-body">
                    <div class="" style="text-align: center;">
                    <h5 class="card-title fw-bold" style="color: green;">Eastwoods Professional College of Science and
                        Technology</h5>
                    <p class="card-text mb-5" style="text-transform: uppercase;">PATIENT HEALTH DETAILS</p>

                </div>
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
                        <label for="recipient-name" class="col-form-label fw-bold">Course:</label>
                        <br>
                        <label for="" class="ms-2">{{ userInfo.course }}</label>
                      </div>
                  </div>
                </div>
                <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Vital Signs</th>
                    <th scope="col">Chief Complaint</th>
                    <th scope="col">Medication Given</th>
                  </tr>
                </thead>
                <tbody>
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

                                </tr>
                      </tbody>
          </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click="print" class="btn btn-success">Print</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {reactive, ref,toRef,watch} from 'vue'
import axios from 'axios';
import moment from 'moment';
import { usePaperizer } from 'paperizer'
const props = defineProps(['userInfo','view'])
const newProps = toRef(props,'userInfo')
const state = reactive({
    school_year_semester:'',
    student_id:''
})
const medicalHistory = ref([

    // Add more entries as needed
]);
watch(props, async (newV,oldV) =>{

    if(newV.view)
    {
        state.student_id = newProps.value.student_no;
        state.school_year_semester = newProps.value.school_year_semester;
        await getStudentRecord()
    }
})



//print
const { paperize } = usePaperizer('print-me',{
  styles: [
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'
  ],
  features:[
    'fullscreen=yes'
  ],
  autoClose: true,
  target: '_blank'
})
const print = () =>{
    paperize()

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
}
</style>

