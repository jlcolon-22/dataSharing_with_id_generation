<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" data-backdrop="static">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Student Information</h5>
                        <button type="button" class="btn-close" @click="$emit('close')"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Student Info -->
                        <div class="row">
                            <div class="col-md-2">
                                            <label for="recipient-name" class="col-form-label fw-bold">First Name:</label>
                                            <br>
                                            <label for="recipient-name" class="col-form-label text-uppercase"
                                                style="text-wrap: nowrap;">{{
                                                    userInfo.first_name }}</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="recipient-name" class="col-form-label fw-bold">Middle Name:</label>
                                            <br>
                                            <label for="recipient-name" class="col-form-label text-uppercase"
                                                style="text-wrap: nowrap;">{{
                                                    userInfo.middle_name }}</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="recipient-name" class="col-form-label fw-bold">Last Name:</label>
                                            <br>
                                            <label for="recipient-name" class="col-form-label text-uppercase"
                                                style="text-wrap: nowrap;">{{
                                                    userInfo.last_name }}</label>
                                        </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label fw-bold">Course Name:</label>
                                            <br>
                                            <label for="recipient-name" class="col-form-label text-uppercase">{{
                                                userInfo.course }}</label>
                                        </div>
                                    </div>
                        </div>
                        <hr>
                        <!-- If may nag bayad ng sobra na tuition sa dapat na bayaran ng student is mababawasan yung tuition sa next semi month lang and
                  hindi to mag papaid hanngat di namemeet yung tuition na dapat bayaran sa month na yon
              -->
                        <!-- View Semi Monthly Partition  -->
                        <h5 class="fw-bold">View Semi Monthly Partition</h5>
                        <!-- alert -->
                        <div v-show="check" class="alert alert-warning" role="alert">
                            <strong> The student does not have any available fee details. Please add fee details
                                first!</strong>
                        </div>

                        <table v-show="check == false" class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Partition</th>

                                    <th>Semi Monthly</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through the partition items -->
                                <tr v-for="(partitionItem, index) in partitionItems" :key="index">
                                    <td>{{partitionItem.partition }}</td>

                                    <td>
                                        <label for="" class="fw-bold ">
                                            <i class="fa-solid fa-peso-sign"></i>
                                            {{ partitionItem.status ?  parseFloat(feedetails.semi_monthly_dues).toLocaleString('en-US') :  parseFloat(partitionItem.amount).toLocaleString('en-US') }}
                                        </label>
                                    </td>
                                    <td>
                                        <span
                                            :class="partitionItem.status ? 'badge bg-success' : 'badge bg-warning'">{{
                                                partitionItem.status ? 'Paid' : 'Unpaid' }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- View Payment Details -->
                        <center class="mt-5">
                            <h4 for="" class="fw-bold">Payment Details</h4>
                        </center>
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>OR Number</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through the payment items -->
                                <tr v-for="(paymentItem, index) in paymentItems" :key="index">
                                    <td>{{ moment(paymentItem.created_at).format('MMM D YYYY') }}</td>
                                    <td>{{ paymentItem.or_number }}</td>
                                    <td><i class="fa-solid fa-peso-sign"></i>{{ parseFloat(paymentItem.amount).toLocaleString('en-US') }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- View Other Payment Details -->
                        <center class="mt-5">
                            <h4 for="" class="fw-bold">Other Payment Details</h4>
                        </center>
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through the payment items -->
                                <tr v-for="(otherPayment, index) in otherPaymentItems" :key="index">
                                    <td>{{ moment(otherPayment.created_at).format('MMM D YYYY') }}</td>
                                    <td>{{ otherPayment.remarks }}</td>
                                    <td><i class="fa-solid fa-peso-sign"></i>{{ parseFloat(otherPayment.amount).toLocaleString('en-US') }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Total Paid -->
                        <div class="row mt-5">
                            <div class="col-md-5">
                                <div class="d-flex align-items-baseline">
                                    <label for="" class="fw-bold">Total Paid:</label>
                                </div>
                            </div>
                            <div class="col" style="">
                                <label for="" class="fw-bold d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-peso-sign"></i>
                                    {{ feedetails.totalPaid.toLocaleString("en-US") }}
                                </label>
                            </div>
                        </div>
                        <!-- Balance-->
                        <div class="row mt-4">
                            <div class="col-md-5">
                                <div class="d-flex align-items-baseline">
                                    <label for="" class="fw-bold">Balance:</label>
                                </div>
                            </div>
                            <div class="col">
                                <label for="" class="fw-bold d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-peso-sign"></i>
                                    {{ feedetails != 0 ? feedetails.balance.toLocaleString("en-US") : 0 }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, defineProps, watch, toRef, ref } from "vue";
import moment from "moment";
const props = defineProps(['userInfo','view']);
const newProps = toRef(props, 'userInfo');
const partitionItems = ref([
]);
const paymentItems = ref([
]);
const otherPaymentItems = ref([]);
const check = ref(false);
const state = reactive({
    payment_details_id: ''
})
const feedetails = reactive({
    payable: 0,
    semi_monthly_dues: 0,
    totalPaid: 0,
    balance: 0,
    partition: 0
});

watch(props, async (newValue, oldValue) => {
    if(newValue.view)
    {
        await getStudentData()

    }
})

const getStudentData = async () => {

    const res = await axios.post('/api/cashier/student_payment', { school_year_semester: newProps.value.school_year_semester, student_id: newProps.value.student_no });

    if (res.status == 200) {
        check.value = false;
        state.payment_details_id = res.data.id;
        feedetails.payable = res.data.total_payable_fee;
        feedetails.semi_monthly_dues = parseFloat(res.data.total_payable_fee) / parseFloat(res.data.partition);
        feedetails.semi_monthly_dues = parseFloat(feedetails.semi_monthly_dues).toFixed(2)
        feedetails.value = res.data;
        feedetails.partition = res.data.partition
        partitionItems.value = res.data.get_student_partition.filter(value =>{
            value.amount = parseFloat(value.amount).toFixed(2);
            return value;
        });
        await fetchStudentPayment();
        await getOtherPayment()
    } else {
        check.value = true;
        paymentItems.value = [];
        feedetails.payable = 0;
        feedetails.semi_monthly_dues = 0;
        feedetails.totalPaid = 0;
        feedetails.balance = 0
        feedetails.partition = 0;
        partitionItems.value = [];

    }



}

// fetch student payment
const fetchStudentPayment = async () => {
    // partitionItems.value = [];
    const { data } = await axios.get('/api/cashier/student_payment/' + state.payment_details_id);

    paymentItems.value = data[1]
    let totalPaid = 0;

    data[1].forEach(value => {

        totalPaid = parseFloat(totalPaid) + parseFloat(value.amount);
    });
    const pay = feedetails.payable / feedetails.partition;
    const oldBalance = parseFloat(pay).toFixed(2) * feedetails.partition;
    // console.log(totalPaid + ' / ' + oldBalance)
    feedetails.totalPaid = totalPaid;
    feedetails.balance = totalPaid == parseFloat(oldBalance).toFixed(2) ? 0 : parseFloat(oldBalance).toFixed(2) - totalPaid;
    // feedetails.totalPaid = totalPaid;
    // feedetails.balance = parseFloat(feedetails.payable) - parseFloat(totalPaid);


}

// fetch other payment
const getOtherPayment = async () =>{
    const res = await axios.post('/api/cashier/other/student_payment',{ school_year_semester: newProps.value.school_year_semester, student_id: newProps.value.student_no });
    otherPaymentItems.value = res.data[0];
    console.log(res.data)
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

