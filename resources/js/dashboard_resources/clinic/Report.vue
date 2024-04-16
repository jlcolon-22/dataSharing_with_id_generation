<template>
    <div class=" " style="max-height: calc(100vh - 80px);padding:30px 20px 10px 30px; overflow-y: auto;">
        <div class="dashboard_header mt-3">
            <h1 class="fw-bold">View Reports</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </nav>
            <!-- Datepicker -->
            <div class="mb-3">
                <label for="datepicker" class="form-label fw-bold">Select a Date:</label>
                <input type="date" @change="fetch" id="datepicker" class="form-control" style="width: 240px;">
            </div>
        </div>

        <!-- You can see here the daily report transactions -->

        <!-- Reports -->
        <div class="card  mt-5 w-100">
            <section style="max-height: 500px;overflow-y: auto;">
                <div class="card-header">
                    Daily Reports Worksheet
                </div>
                <div  class="card-body"  id="print-me">
                    <div v-show="check" class="alert alert-danger">
                        <strong>No Result!</strong>
                    </div>
                    <div class="" style="text-align: center;">
                        <h5 class="card-title fw-bold" style="color: green;">Eastwoods Professional College of Science and
                            Technology</h5>
                        <p class="card-text" style="text-transform: uppercase;">Daily Reports Worksheet</p>
                        <label for="" style="color: red;" class="fw-bold"> {{ moment(date).format('dddd MMM D YYYY')
                        }}</label>
                    </div>


                    <!-- Daily Transaction -->
                    <div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student Name</th>

                                    <th>Vital Signs</th>
                                    <th>Chief Complaint</th>
                                    <th>Medication Given</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Your table data will go here -->
                                <!-- Static for now -->
                                <!-- For example: -->
                                <tr v-for="record in records" :key="record.id">
                                    <td>{{ moment(record.created_at).format('MMM D YYYY') }}</td>

                                    <td>{{ record.student_name }}</td>
                                    <td>
                                        <p><strong>Temperature:</strong> {{ record.temp }} °C</p>
                                        <p><strong>Blood Pressure:</strong> {{ record.bp }} mmHg</p>
                                        <p><strong>Respiratory Rate:</strong> {{ record.rr }} breaths/min</p>
                                        <p><strong>Pulse Rate:</strong> {{ record.pr }} bpm</p>
                                    </td>
                                    <td>{{ record.chief_complain.toLocaleString('en-US') }}</td>
                                    <td>{{ record.medication_given }}</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>
                </div>
            </section>
            <!-- Summary of transactions -->
            <div class="" style="margin-left: 1rem;;">

                <button class="btn btn-success" v-print="printObject"
                    style="float: right; margin-top: 1rem; margin-right: 1rem;margin-bottom: 1rem;">Print</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { computed, onBeforeMount, reactive, ref } from "vue";
import moment from 'moment'

const printObject = ref({
    id: 'print-me',
    extraCss: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
    popTitle: 'Cashier Reports',
})
// import print from 'vue3-print-nb'

// directives: {
//     print
// }
//print
// const { paperize } = usePaperizer('print-me', {
//     styles: [
//         'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'
//     ],
//     features: [
//         'fullscreen=yes'
//     ],
//     autoClose: true,
//     target: '_blank'
// })
// const print = () => {
//     paperize()

// }
const records = ref([

]);


const check = ref(false)

const date = ref(moment());
// kukunin yung data kung anong date yung pinili
const fetch = async (e) => {
    const dateValue = e.target.value;
    date.value = dateValue;

    const res = await axios.post('/api/clinic/reports', { date: dateValue });
    if (res.status == 200) {

        check.value = false
        records.value = res.data;

    } else {

        records.value = [];




    }

}






</script>


<style scoped>
/* .dashboard_header { */
/* margin: 0 auto; */
/* margin-left: 12rem */
/* } */
/* .card {
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
  } */
/* Mobile styles (default) */

#datepicker {
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
    width: 100%;
}


/* Tablet and desktop styles */
@media screen and (min-width: 768px) {
    .dashboard_header {
        max-width: 70%;
    }

    /* .card { */
    /* margin-left: 12rem; */
    /* } */
}

/* Large desktop styles */
@media screen and (min-width: 1200px) {
    .dashboard_header {
        max-width: 60%;
    }
}
</style>
