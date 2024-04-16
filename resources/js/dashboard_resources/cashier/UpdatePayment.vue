<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" data-backdrop="static">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Student Payment</h5>
                        <button type="button" class="btn-close" @click="$emit('close')" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-show="check" class="alert alert-warning" role="alert">
                            <strong> The student does not have any available fee details. Please add fee details
                                first!</strong>
                        </div>
                        <ul v-show="check == false" class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#update-home" type="button" role="tab" aria-controls="update-home"
                                    aria-selected="true">Tuition Fee</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other"
                                    type="button" role="tab" aria-controls="other" aria-selected="false">Other Fee</button>
                            </li>

                        </ul>
                        <div v-show="check == false" class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="update-home" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div v-if="oldFee > 0.0" class="alert alert-info" role="alert">
                                    <strong>The student has a balance of <i class="fa-solid fa-peso-sign"></i>{{ oldFee.toLocaleString('en-US') }} from the last term.</strong>
                                </div>
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
                                <div class="row mt-5">
                                    <!--Fee Details-->
                                    <form @submit.prevent="addStudentPayment" class="col-md-6 fee-payment-container">
                                        <h4 for="" class="fw-bold" style="color: green;">Fee Details</h4>

                                        <label for="" class="fw-bold mt-3">Total Payable Fee</label> <br>
                                        <label for="">
                                            <i class="fa-solid fa-peso-sign"></i>
                                            {{ feedetails.payable.toLocaleString("en-US") }}
                                        </label>

                                        <div class="mt-3">
                                            <label for="" class="fw-bold mt-3">Semi Monthly Dues</label> <br>
                                            <input type="text" disabled class="form-control mt-3"
                                                :placeholder="feedetails.semi_monthly_dues"
                                                :value="'₱ ' + parseFloat(feedetails.semi_monthly_dues).toLocaleString('en-US')">
                                        </div>
                                        <div>
                                            <label for="" class="fw-bold mt-3">Remarks</label> <br>
                                            <input type="text" v-model="state.remarks" required class="form-control mt-3">
                                        </div>
                                        <div>
                                            <label for="" class="fw-bold mt-3">OR Number</label> <br>
                                            <input type="number" v-model="state.or_number" required
                                                class="form-control mt-3">
                                                <small class="text-danger" v-if="errors.or_number">{{ errors.or_number[0] }}</small>
                                        </div>

                                        <!-- If lumampas yung binayad doon sa semi monthly is dapat mag adjust yung babayaran next semi month -->
                                        <div>
                                            <label for="" class="fw-bold mt-3">Amount</label> <br>
                                            <input type="number" step="0.01" :max="feedetails.balance"
                                                v-model="state.amount" required class="form-control mt-3">
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                    <!-- Payment Details -->
                                    <div class="col-md-6">
                                        <h4 for="" class="fw-bold" style="color: green;">Payment Details</h4>
                                        <table class="table table-striped mt-5">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Remarks</th>
                                                    <th>OR Number</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Loop through the payment items -->
                                                <tr v-for="(paymentItem, index) in paymentItems" :key="index">
                                                    <td>{{ moment(paymentItem.created_at).format('MMM D YYYY') }}</td>
                                                    <td>{{ paymentItem.remarks }}</td>
                                                    <td>{{ paymentItem.or_number }}</td>
                                                    <td><i class="fa-solid fa-peso-sign"></i> {{
                                                        parseFloat(paymentItem.amount).toLocaleString("en-US", {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2
                                                        }) }}</td>
                                                    <td>
                                                        <button style="border: none;"
                                                            @click="deleteStudentPayment(paymentItem.id)"><i
                                                                class="fa-solid fa-square-xmark"
                                                                style="color: red; font-size: 35px;"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Total Paid -->
                                        <div class="row mt-5">
                                            <div class="">
                                                <label for="" class="fw-bold">Total Paid:</label>
                                                <label for="" class="fw-bold" style="margin-left: 1rem;">
                                                    <i class="fa-solid fa-peso-sign"></i>
                                                    {{ feedetails.totalPaid.toLocaleString("en-US") }}
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Balance-->
                                        <div class="row mt-4">
                                            <div class="">
                                                <label for="" class="fw-bold">Balance:</label>
                                                <label for="" class="fw-bold" style="margin-left: 1rem;">
                                                    <i class="fa-solid fa-peso-sign"></i>
                                                    {{ feedetails != 0 ? feedetails.balance.toLocaleString("en-US") : 0 }}
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="profile-tab"
                                tabindex="0">
                                <div v-if="oldOtherFee > 0.0" class="alert alert-info" role="alert">
                                    <strong>The student has a balance of <i class="fa-solid fa-peso-sign"></i>{{ oldOtherFee.toLocaleString('en-US') }} from the last term.</strong>
                                </div>
                                <div class="p-5">
                                    <form @submit.prevent="addStudentOtherPayment"
                                        class=" d-flex justify-content-between gap-5 align-items-end "
                                        style="max-width: 650px">
                                        <div class="col-md-3">
                                            <label for="">Fee type</label>
                                            <select required v-model="otherFeeSelectModel" class="form-select">
                                                <option selected value="">Choose...</option>
                                                <option v-for="item in otherFeeData" :key="item.id" :value="item">
                                                    {{ item.fee_type }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="">Amount</label>
                                            <input type="number" required v-model="otherFeeModel.amount"
                                                class="form-control" disabled>
                                        </div>


                                        <div class="col-md-3 mt-4">
                                            <button type="submit" class="btn btn-success">Update</button>

                                        </div>
                                    </form>

                                    <div>
                                        <div class=" mt-5">
                                            <h4 for="" class="fw-bold" style="color: green;">Fee Details</h4>
                                            <table class="table table-striped mt-5">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Remarks</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Loop through the payment items -->
                                                    <tr v-for="(item, index) in otherFeeDatas" :key="index">
                                                        <td>{{ moment(item.created_at).format('MMM D YYYY') }}</td>
                                                        <td>{{ item.fee_type }}</td>
                                                        <td><i class="fa-solid fa-peso-sign"></i>{{
                                                            parseFloat(item.amount).toLocaleString("en-US", {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionDigits: 2
                                                            }) }}</td>
                                                        <td>

                                                            <span
                                                                :class="item.status ? 'badge bg-success' : 'badge bg-warning'">{{
                                                                    item.status ? 'Paid' : 'Unpaid' }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>

                                        <div class=" mt-5">
                                            <h4 for="" class="fw-bold" style="color: green;">Payment Details</h4>
                                            <table class="table table-striped mt-5">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Remarks</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Loop through the payment items -->
                                                    <tr v-for="(paymentItem, index) in otherPaymentItems" :key="index">
                                                        <td>{{ moment(paymentItem.created_at).format('MMM D YYYY') }}</td>
                                                        <td>{{ paymentItem.remarks }}</td>
                                                        <td><i class="fa-solid fa-peso-sign"></i>{{
                                                            parseFloat(paymentItem.amount).toLocaleString("en-US", {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionDigits: 2
                                                            }) }}</td>
                                                        <td>
                                                            <button style="border: none;"
                                                                @click="deleteOtherStudentPayment(paymentItem.id)"><i
                                                                    class="fa-solid fa-square-xmark"
                                                                    style="color: red; font-size: 35px;"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>


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
import axios from "axios";
import { reactive, watch, toRef, ref } from "vue";
import { useToast } from "vue-toast-notification";
import moment from 'moment'

const props = defineProps(['userInfo', 'update']);
const newProps = toRef(props, 'userInfo');
const check = ref(false);
const $toast = useToast();
const otherFeeModel = reactive({
    id: '',
    amount: '',
    payment_details_id: '',
    student_id: ''
})
const feedetails = reactive({
    payable: 0,
    semi_monthly_dues: 0,
    totalPaid: 0,
    balance: 0,
    partition: 0
});
const state = reactive({
    remarks: '',
    or_number: '',
    amount: '',
    payment_details_id: '',
    student_id: ''
})
const paymentItems = ref([

])
const otherPaymentItems = ref([]);
const otherFeeData = ref([]);
const otherFeeDatas = ref([]);
const otherFeeSelectModel = ref('');
const oldFee = ref(0);
const oldOtherFee = ref(0);
const errors = ref([]);
watch(props, async (newValue, oldValue) => {

    if (newValue.update) {
        await getStudentData()
        await getOtherFee()
        await getOtherPayment()


    }

})
watch(otherFeeSelectModel,(newV,oldV) =>{
    otherFeeModel.id = newV.id;
    otherFeeModel.amount = newV.amount;
})
// get student payment data
const getStudentData = async () => {

    const res = await axios.post('/api/cashier/student_payment', { school_year_semester: newProps.value.school_year_semester, student_id: newProps.value.student_no });


    if (res.status == 200) {
        check.value = false;
        state.payment_details_id = res.data.id;
        state.student_id = res.data.student_id;
        otherFeeModel.payment_details_id = res.data.id;
        otherFeeModel.student_id = res.data.student_id;
        feedetails.payable = res.data.total_payable_fee;
        const semi = res.data.get_student_partition.find(value => {
            return value.status == 0;
        });
        feedetails.semi_monthly_dues = semi ? semi.amount : 0;

        feedetails.partition = res.data.partition;

        await fetchStudentPayment();
    } else {
        check.value = true;
        paymentItems.value = [];
        feedetails.payable = 0;
        feedetails.semi_monthly_dues = 0;
        feedetails.totalPaid = 0;
        feedetails.balance = 0;

    }



}

// fetch student payment
const fetchStudentPayment = async () => {
    const { data } = await axios.get('/api/cashier/student_payment/' + state.payment_details_id);
    oldFee.value = data[0]

    paymentItems.value = data[1];
    let totalPaid = 0;
    data[1].forEach(value => {

        totalPaid = parseFloat(totalPaid) + parseFloat(value.amount);
    });
    const pay = feedetails.payable / feedetails.partition;
    const oldBalance = parseFloat(pay).toFixed(2) * feedetails.partition;

    feedetails.totalPaid = totalPaid;
    feedetails.balance = totalPaid == parseFloat(oldBalance).toFixed(2) ? 0 : parseFloat(oldBalance).toFixed(2) - totalPaid;


}

// ADD student payment
const addStudentPayment = async () => {

       try {
        const res = await axios.post('/api/cashier/update/student_payment', state)
        errors.value = []
            state.or_number = '';
        state.remarks = '';
        state.amount = '';
        getStudentData()

       } catch (error) {
            errors.value = error.response.data.errors

       }




}
const addStudentOtherPayment = async () => {
    await axios.post('/api/cashier/update/other/student_payment', otherFeeModel);
    otherFeeModel.amount = '';
    otherFeeModel.id = '';
    getOtherFee()
    getOtherPayment();
}
// delete student payment
const deleteStudentPayment = async (id) => {
    const { data } = await axios.delete('/api/cashier/delete/student_payment/' + id);
    getStudentData()
}


// fetch otherpayment
const getOtherFee = async () => {
    const res = await axios.post('/api/cashier/other/fee', { school_year_semester: newProps.value.school_year_semester, student_id: newProps.value.student_no })

    if (res.status == 200) {
        otherFeeData.value = res.data.get_fee_details.filter(value => { return value.status == 0 });
        otherFeeDatas.value = res.data.get_fee_details;
    } else {
        otherFeeData.value = [];
    }
}

// fetch other STUDENT PAYMENT
const getOtherPayment = async () => {
    const res = await axios.post('/api/cashier/other/student_payment', { school_year_semester: newProps.value.school_year_semester, student_id: newProps.value.student_no });

    if(res.status == 200)
    {
        oldOtherFee.value = res.data[1]
        otherPaymentItems.value = res.data[0];
    }else{
        otherPaymentItems.value = [];
    }
}

// delete other payment
const deleteOtherStudentPayment = async (id) => {
    const res = await axios.delete('/api/cashier/delete/other/student_payment/' + id);
    getOtherFee();
    getOtherPayment();
}




</script>
<style>
/* Add your custom styles here if needed */
.fee-payment-container::after {
    content: "";
    position: absolute;
    bottom: 0;
    right: 50%;
    border-left: 1px solid #ccc;
    height: 80%;
}</style>
