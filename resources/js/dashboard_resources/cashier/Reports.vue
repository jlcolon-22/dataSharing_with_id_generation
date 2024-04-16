<template>
    <div class=" " style="height: 650px;padding:30px 20px 100px 30px; overflow-y: scroll;">
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
            <div class="card-header">
                Daily Collection Worksheet
            </div>
            <div id="print-me"  class="card-body">
                <div v-show="check" class="alert alert-danger">
                    <strong>No Result!</strong>
                </div>
                <div class="" style="text-align: center;">
                    <h5 class="card-title fw-bold" style="color: green;">Eastwoods Professional College of Science and
                        Technology</h5>
                    <p class="card-text" style="text-transform: uppercase;">Daily Collection Worksheet</p>
                    <label for="" style="color: red;" class="fw-bold"> {{ moment(date).format('dddd MMM D YYYY') }}</label>
                </div>


                <!-- Daily Transaction -->
                <div >
                    <center>
                    <h4 class="text-success mt-5">Student Payment</h4>
                </center>
                    <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>OR Number</th>
                            <th>Student Name</th>

                            <th>Payments</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Your table data will go here -->
                        <!-- Static for now -->
                        <!-- For example: -->
                        <tr v-for="transaction in transactions" :key="transaction.id">
                            <td>{{ moment(transaction.created_at).format('MMM D YYYY') }}</td>
                            <td>{{ transaction.or_number }}</td>
                            <td>{{ transaction.student_tuition.student_name }}</td>

                            <td><i class="fa-solid fa-peso-sign"></i>{{ parseFloat(transaction.amount).toLocaleString('en-US') }}</td>
                            <td>{{ transaction.remarks }}</td>
                        </tr>
                    </tbody>
                </table>
                <center>
                    <h4 class="text-success mt-5">School Fee</h4>
                </center>
                <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>

                            <th>Student Name</th>

                            <th>Payments</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Your table data will go here -->
                        <!-- Static for now -->
                        <!-- For example: -->
                        <tr v-for="transaction in transactionsSchoolFee" :key="transaction.id">
                            <td>{{ moment(transaction.created_at).format('MMM D YYYY') }}</td>

                            <td>{{ transaction.student_tuition.student_name }}</td>

                            <td><i class="fa-solid fa-peso-sign"></i>{{ parseFloat(transaction.amount).toLocaleString('en-US') }}</td>
                            <td>{{ transaction.remarks }}</td>
                        </tr>
                    </tbody>
                </table>
                <center>
                    <h4 class="text-success mt-5">Other Fee</h4>
                </center>
                <table  class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Full Name</th>
                            <th>Payments</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Your table data will go here -->
                        <!-- Static for now -->
                        <!-- For example: -->
                        <tr v-for="transaction in otherTransactions" :key="transaction.id">
                            <td>{{ moment(transaction.created_at).format('MMM D YYYY') }}</td>

                            <td>{{ transaction.fullname }}</td>
                            <td><i class="fa-solid fa-peso-sign"></i>{{ parseFloat(transaction.amount).toLocaleString('en-US') }}</td>
                            <td>{{ transaction.remarks }}</td>
                        </tr>
                    </tbody>
                </table>

                <label for="" class="fw-bold" style="color: green;">Summary of Collections </label>
                <hr>
                <div class="mt-3">
                    <label for="" class="fw-bold"> Tuition Fee College : </label>
                    <label for="" class="fw-bold" style="margin-left: 1rem;">
                        <i class="fa-solid fa-peso-sign"></i>
                        {{ feeTotal.toLocaleString('en-US') }}
                    </label>
                </div>
                <div class="mt-3">
                    <label for="" class="fw-bold">School Fee : </label>
                    <label for="" class="fw-bold" style="margin-left: 1rem;">
                        <i class="fa-solid fa-peso-sign"></i>
                        {{ schoolFeeTotal.toLocaleString('en-US') }}
                    </label>
                </div>
                <div class="mt-3">
                    <label for="" class="fw-bold">Other Collection : </label>
                    <label for="" class="fw-bold" style="margin-left: 1rem;">
                        <i class="fa-solid fa-peso-sign"></i>
                        {{ otherCollection.toLocaleString('en-US') }}
                    </label>
                </div>
                <div class="mt-3">
                    <label for="" class="fw-bold">Grand Total : </label>
                    <label for="" class="fw-bold" style="margin-left: 1rem;">
                        <i class="fa-solid fa-peso-sign"></i>
                        {{ total.toLocaleString('en-US') }}
                    </label>
                </div>
                </div>
            </div>
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
    id:'print-me',
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
const transactions = ref([

]);
const otherTransactions = ref([])
const transactionsSchoolFee = ref([])
const total = ref(0)
const otherCollection = ref(0);
const feeTotal = ref(0);
const schoolFeeTotal = ref(0);
const check = ref(false)
const sortedTransactions = computed(() => {
    return transactions.value.sort((a, b) => new Date(a.date) - new Date(b.date));
})
const date = ref(moment());
// kukunin yung data kung anong date yung pinili
const fetch = async (e) => {
    const dateValue = e.target.value;
    date.value = dateValue;

    const res = await axios.post('/api/cashier/reports', { date: dateValue });
    if (res.status == 200) {
        transactions.value = res.data.filter(value =>{
            return value.type == 0;
        });
        transactionsSchoolFee.value = res.data.filter(value =>{
            return value.type == 1;
        });
        let totalFee = 0;
        transactions.value.forEach(element => {
            totalFee = totalFee + parseFloat(element.amount)
        });
        let schoolTotal = 0;
        transactionsSchoolFee.value.forEach(element => {
            schoolTotal = schoolTotal + parseFloat(element.amount)
        });
        schoolFeeTotal.value = schoolTotal;
        feeTotal.value = totalFee
        total.value = totalFee + schoolTotal;
        check.value = false

        await fetchOtherPayment(dateValue)
    } else {
        total.value = 0;
        transactions.value = [];
        await fetchOtherPayment(dateValue)



    }

}

// kukunin lahat ng other payment like parent request
const fetchOtherPayment = async (d) =>{
    const res = await axios.get('/api/cashier/other_payment?date='+d);
    if(res.status == 200)
    {
        otherTransactions.value = res.data;
    var totalamount = 0;
    res.data.forEach(element => {
        totalamount = totalamount + parseFloat(element.amount)
        });
        otherCollection.value = totalamount;
    total.value = total.value + totalamount;
    check.value = false;
    }else{
        otherTransactions.value = [];
        total.value = total.value + 0;
        if(total.value == 0)
        {
            check.value = true;
        }
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
