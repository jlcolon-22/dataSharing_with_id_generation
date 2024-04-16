<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="previewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" data-backdrop="static">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Preview Assesment Information</h5>
                        <button type="button" class="btn-close" @click="$emit('close')"  data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Dito magdidisplay yung mga ininput na mga babayaran galing sa add button (dynamic) -->
                    <div class="modal-body" id="print-me">
                        <!-- Student Assesment -->
                        <div v-show="check" class="alert alert-warning" role="alert">
                            <strong> The student does not have any available fee details. Please add fee details
                                first!</strong>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                Student Assesment
                            </div>
                            <div class="card-body">
                                <div class="" style="text-align: center;">
                                    <h5 class="card-title fw-bold" style="color: green;">Eastwoods Professional College of
                                        Science and Technology</h5>
                                    <p class="card-text" style="text-transform: uppercase;">Brgy. Ibayo Balanga City, Bataan
                                        2100</p>
                                    <label for="" style="" class="fw-bold">Schedule of Payment/Statement of Account</label>
                                    <p v-if="!!state.school_year_semester">{{ !!state.school_year_semester && state.school_year_semester.split('/')[1].split(" ")[1] == '2nd' ? 'Second' : 'First'}} Semester AY {{ !!state.school_year_semester ? state.school_year_semester.split('/')[0] : '' }}</p>
                                </div>

                                <!-- Student Name -->
                                <div class="mt-5">
                                    <label for="" class="fw-bold">Name:</label>
                                    <label for="" style="margin-left: 1rem;">{{ userInfo.first_name+' '+userInfo.middle_name+' '+userInfo.last_name }}</label>
                                </div>

                                <!-- Semi monthly partition -->
                                <div class="mt-5">
                                    <div v-for="(feeItem, index) in state.fee_type" :key="index">
                                        <label for="" class="fw-bold">{{ feeItem.fee_type }} : </label>
                                        <label for="" class="" style="margin-left: 1rem;">
                                            <i class="fa-solid fa-peso-sign"></i>
                                            {{ feeItem.amount }}
                                        </label>
                                    </div>
                                </div>

                                <hr class="" style="width: 20%;">
                                <!-- Total Payable Fee -->
                                <div class="mt-3">
                                    <label for="" class="fw-bold">Total School Fee : </label>
                                    <i class="fa-solid fa-peso-sign" style="margin-left: 1rem;"></i>
                                    <label for="" class="">{{ state.totalSchoolFee.toLocaleString('en-US') }}</label>
                                </div>

                                <hr class="" style="width: 20%;">

                                <!-- Downpayment -->
                                <div class="mt-3">
                                    <label for="" class="fw-bold">Downpayment : </label>
                                    <i class="fa-solid fa-peso-sign" style="margin-left: 1rem;"></i>
                                    <label for="" class=""> {{ state.downpayment ? state.downpayment[0].amount.toLocaleString('en-US') : ''}}</label>
                                </div>
                                <hr class="" style="width: 20%;">
                                <!-- Total Payable Fee -->
                                <div class="mt-3">
                                    <label for="" class="fw-bold">Total Payable Fee : </label>
                                    <i class="fa-solid fa-peso-sign" style="margin-left: 1rem;"></i>
                                    <label for="" class="">{{ state.Total_Payable_Fee.toLocaleString('en-US') }}</label>
                                </div>

                                <!-- Semi monthly partition (static for now) -->
                                <table class="table table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>Partition</th>

                                            <th>Semi Monthly</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Loop through the partition items -->
                                        <tr v-for="(partitionItem, index) in partitionItems" :key="index">
                                            <td>{{ index == 0 ? '1st Payment' : index == 1 ?  '2nd Payment' : index == 2 ? '3rd Payment' : `${index+1}th Payment`  }}</td>

                                            <td>
                                                <label for="" class="fw-bold ">
                                                    <i class="fa-solid fa-peso-sign"></i>
                                                    {{ parseFloat(partitionItem.semiMonthly).toFixed(2) }}
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Display Total Payable Fee-->
                                <div class="row mt-5">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label for="" class="fw-bold">Total Payable Fee:</label>
                                        <label for="" class="fw-bold" style="margin-left: 1rem;">
                                            <i class="fa-solid fa-peso-sign"></i>
                                            {{ state.Total_Payable_Fee.toLocaleString('en-US') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <label for="" class="fw-bold">*Kindly refer to the attached list of PAYMENT
                                        OPTIONS</label> <br>
                                    <label for="" class="mt-5 fw-bold">Acknowledge the receipt of Schedule of
                                        Payments/Statement of Account for <span  v-if="state.school_year_semester">{{ state.school_year_semester.split('/')[1]}} AY {{ state.school_year_semester.split('/')[0] }}</span></label>
                                </div>

                                <!-- Student Info -->
                                <div class="row fw-bold" style="margin-top: 8rem;">
                                    <div class="col-md-6">

                                        <!-- Static for now -->
                                        <label for="" v-if="userInfo.first_name">{{ userInfo.first_name.toUpperCase()+' '+userInfo.middle_name.toUpperCase()+' '+userInfo.last_name.toUpperCase() }}</label>

                                        <hr class="" style="width: 50%;">
                                        <label for="">Student Name</label> <br>
                                        <label for="">(Signature Over Printed Name)</label>
                                    </div>
                                    <!-- Parent Info -->
                                    <div class="col-md-6">
                                        <!-- Static for now -->
                                        <label for="">Abutar, Emma, C.</label>

                                        <hr class="" style="width: 50%;">
                                        <label for="">Parent / Guardian</label> <br>
                                        <label for="">(Signature Over Printed Name)</label>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between;" class="modal-footer ">

                                    <button class="btn btn-success" v-print="printObject" style="float: right;">Print</button>


                        <button type="button" class="btn btn-secondary" @click="$emit('close')" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps, reactive, ref, toRef, watch } from "vue";
import { usePaperizer } from 'paperizer'
const printObject = ref({
    id:'print-me',
    extraCss: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
    popTitle: 'Preview',
})
//print
// const { paperize } = usePaperizer('print-me',{
//   styles: [
//     'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'
//   ],
//   features:[
//     'fullscreen=yes'
//   ],
//   autoClose: true,
//   target: '_blank'
// })
// const print = () =>{
//     paperize()

// }
const props = defineProps(['userInfo','preview']);
const newProps = toRef(props, 'userInfo');
const feeItems = ref([

]);
const partitionItems = ref([
])
const check = ref(false);
const state = reactive({
    payment_details_id: '',
    selectedPartition: '',
    fee_type: [],
    totalSchoolFee: '',
    downpayment: '',
    student_id: '',
    school_year_semester: '',
    Total_Payable_Fee: '',
    section: '',
    student_name: '',
})
const feedetails = reactive({
    payable: 0,
    semi_monthly_dues: 0,
    totalPaid: 0,
    balance: 0,
    partition: 0
});


watch(props, async (newValue, oldValue) => {
    if(newValue.preview)
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
        feedetails.value = res.data;
        feedetails.partition = res.data.partition
        state.fee_type = res.data.get_fee_details.filter(value => {
            return value.fee_type != 'Downpayment' && value.type == 0;
        });
        state.downpayment = res.data.get_fee_details.filter(value => {
            return value.fee_type == 'Downpayment';
        });
        state.school_year_semester = res.data.school_year_semester;
        state.totalSchoolFee = res.data.total_school_fee;
        state.Total_Payable_Fee = res.data.total_payable_fee;
        await fetchStudentPayment();
    } else {
        check.value = true;
        // paymentItems.value = [];
        feedetails.payable = 0;
        feedetails.semi_monthly_dues = 0;
        feedetails.totalPaid = 0;
        feedetails.balance = 0
        feedetails.partition = 0;
        state.Total_Payable_Fee = 0;
        state.totalSchoolFee = 0;
        state.downpayment = 0;
        state.fee_type = []
        partitionItems.value = [];

    }



}

// fetch student payment
const fetchStudentPayment = async () => {
    partitionItems.value = [];
    const { data } = await axios.get('/api/cashier/student_payment/' + state.payment_details_id);

    // paymentItems.value = data;
    let totalPaid = 0;
    data.forEach(value => {
        totalPaid = totalPaid + value.amount;
    });

    for (var i = 1; i <= feedetails.partition; i++) {
        partitionItems.value.push({ semiMonthly: feedetails.semi_monthly_dues})
    }
    feedetails.totalPaid = totalPaid;
    feedetails.balance = parseFloat(feedetails.payable) - parseFloat(totalPaid);


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

