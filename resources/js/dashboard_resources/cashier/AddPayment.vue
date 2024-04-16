<template>
    <div>


        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" data-backdrop="static">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Student Payment</h5>
                        <button type="button" @click="$emit('close')" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                                    aria-selected="true">Tuition Fee</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-tab-pane" type="button" role="tab"
                                    aria-controls="profile-tab-pane" aria-selected="false">Other Fee</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <!-- Student Info -->
                                <div class="row d-flex justify-content-between">
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
                                <!-- Fee Design -->
                                <label for="" class="fw-bold mt-5">Fee Details</label>
                                <div class="row fee mt-4">


                                    <!-- If select 7th semi monthly, the total payable fee must be divided into 7 and
                                    if  select 8th semi monthly, the total payable fee must be divided into 8

                                    -->

                                    <!-- Partition Dropdown -->
                                    <div class="col-md-3">
                                        <label for="" class="fw-bold">Select Partition</label>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle"
                                                :class="(errors[1] && errors[1].selectedPartition) || (errors[0] && errors[0].selectedPartition) ? 'border border-2 border-danger' : ''"
                                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                {{ selectedPartitionText }}
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="#"
                                                        @click="selectPartition('7', '7th monthly')">7th semi monthly</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        @click="selectPartition('8', '8th monthly')">8th semi monthly</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fee Table -->
                                <table v-if="check" class="table table-striped mt-5">
                                    <thead>
                                        <tr>
                                            <th>Fee Type</th>
                                            <th>Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Your table data will go here -->
                                        <!-- Static for now -->
                                        <!-- For example: -->
                                        <tr v-for="(feeItem, index) in state.fee_type" :key="index">
                                            <td>{{ feeItem.fee_type }}</td>
                                            <td><input type="number" disabled @change="changeAmount(index)" class="form-control "
                                                    style="width: 200px;" :value="feeItem.amount"></td>

                                        </tr>
                                        <tr v-show="!!state.downpayment">
                                            <td>Downpayment</td>
                                            <td><input type="number" disabled class="form-control " style="width: 200px;"
                                                    :value="state.downpayment"></td>

                                        </tr>


                                    </tbody>
                                </table>
                                <table v-if="check == false" class="table table-striped mt-5">
                                    <thead>
                                        <tr>
                                            <th>Fee Type</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Your table data will go here -->
                                        <!-- Static for now -->
                                        <!-- For example: -->
                                        <tr v-for="(feeItem, index) in state.fee_type" :key="index">
                                            <td>{{ feeItem.fee_type }}</td>
                                            <td><input type="number" @change="changeAmount(index)" class="form-control "
                                                    style="width: 200px;" :value="feeItem.amount"></td>
                                            <td>
                                                <button @click="removeFeeItem(index)"
                                                    style="background: none; border: none;"><i
                                                        class="fa-solid fa-square-xmark"
                                                        style="color: red; font-size: 35px;"></i></button>
                                            </td>
                                        </tr>

                                        <!-- Downpayment -->
                                        <tr v-show="!!state.downpayment">
                                            <td>Downpayment</td>
                                            <td><input type="text" disabled class="form-control " style="width: 200px;"
                                                    :value="state.downpayment"></td>
                                            <td><button @click="state.downpayment = ''"
                                                    style="background: none; border: none;"><i
                                                        class="fa-solid fa-square-xmark"
                                                        style="color: red; font-size: 35px;"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <form v-if="check == false"  @submit.prevent="saveFee" class="d-flex  align-items-end "
                                    :class="addMore ? 'justify-content-between' : 'justify-content-end'">
                                    <div class="col-md-3" v-show="addMore">
                                        <label for="">Fee Type</label>
                                        <input type="text" required v-model="model.fee" class="form-control">
                                    </div>
                                    <div class="col-md-3" v-show="addMore">
                                        <label for="">Amount</label>
                                        <input type="number" required v-model="model.amount" class="form-control">
                                    </div>
                                    <button v-show="addMore == false" @click="addMore = true" class="btn btn-success "
                                        style="height: fit-content;">Add more</button>

                                    <div class="d-flex gap-2">
                                        <button v-show="addMore" type="submit" class="btn btn-primary">Add to list</button>
                                        <button v-show="addMore" type="button" @click="addMore = false"
                                            class="btn btn-danger">Cancel</button>
                                    </div>

                                </form>
                                <!-- Display Total School Fee -->
                                <div class="row mt-5">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label for="" class="fw-bold">TOTAL SCHOOL FEE:</label>
                                        <label for="" class="fw-bold" style="margin-left: 1rem;"><i
                                                class="fa-solid fa-peso-sign"></i>{{
                                                    state.totalSchoolFee.toLocaleString("en-US")
                                                }}</label>
                                    </div>

                                </div>
                                <!--  Input for Downpayment -->
                                <div class="row mt-5">
                                    <div class="col-md-3">
                                        <form v-if="check == false" @submit.prevent="saveDownPayment" class="d-flex align-items-baseline">
                                            <label for="" class="fw-bold">Downpayment:</label>
                                            <input type="number" required v-model="dp"  :max="state.Total_Payable_Fee"
                                                :class="(errors[0] && errors[0].downpayment) || (errors[1] && errors[1].downpayment) ? 'border border-3 border-danger' : ''"
                                                class="form-control mx-2" style="width: 200px;">
                                        </form>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <hr style="width: 30%; color: #000000;">
                                </div>

                                <!-- Display Total Payable Fee-->
                                <div class="row mt-5">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label for="" class="fw-bold">Total Payable Fee:</label>
                                        <label for="" class="fw-bold" style="margin-left: 1rem;">
                                            <i class="fa-solid fa-peso-sign"></i>
                                            {{ state.Total_Payable_Fee.toLocaleString("en-US") }}
                                        </label>
                                    </div>
                                </div>
                                <div v-if="checkStudentData" class="alert alert-danger" role="alert">
                                    <strong> The student already has saved data for this semester.</strong>
                                </div>
                                <div v-if="partition && downpayments == false" class="alert alert-danger" role="alert">
                                    <li><strong>Required Partition.</strong></li>
                                </div>
                                <div v-if="partition == false && downpayments == true" class="alert alert-danger" role="alert">
                                    <li><strong>Required Downpayment.</strong></li>
                                </div>
                                <div v-if="partition == true && downpayments == true" class="alert alert-danger" role="alert">
                                    <li><strong>Required Partition.</strong></li>
                                    <br>
                                    <li><strong>Required Downpayment.</strong></li>
                                </div>
                                <div class="pt-4 d-flex justify-content-end gap-3">

                                    <button type="button" @click="store" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" ref="addModals" @click="$emit('close');removes()"
                                        >Close</button>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                                tabindex="0">

                                <div class="p-5">
                                    <form @submit.prevent="saveOtherFee"
                                        class=" d-flex justify-content-between gap-5 align-items-end "
                                        style="max-width: 650px">
                                        <div>
                                            <label for="">Fee Type</label>
                                            <input type="text" required v-model="otherFeeModel.fee" class="form-control">
                                        </div>
                                        <div class=" mt-3">
                                            <label for="">Amount</label>
                                            <input type="number" required v-model="otherFeeModel.amount"
                                                class="form-control">
                                        </div>


                                        <div class=" mt-4">
                                            <button v-if="update == false" type="submit" class="btn btn-primary">Add Other
                                                Fee</button>
                                            <button v-if="update == true" type="submit" class="btn btn-success"
                                                style="margin-right: 2px;">Update</button>
                                            <button v-if="update == true" @click="cancelUpdate()" type="button"
                                                class="btn btn-danger">Cancel</button>

                                        </div>

                                    </form>

                                    <table class="table table-striped mt-5">
                                        <thead>
                                            <tr>
                                                <th>Fee Type</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Your table data will go here -->
                                            <!-- Static for now -->
                                            <!-- For example: -->
                                            <tr v-for="(feeItem, index) in otherFeeData" :key="index">
                                                <td>{{ feeItem.fee_type }}</td>
                                                <td><i class="fa-solid fa-peso-sign"></i>{{parseFloat(feeItem.amount).toLocaleString('en-US')}}</td>
                                                <td>
                                                    <button @click="edit(index)" style="background: none; border: none;"><i
                                                            class="fa-solid fa-pen-to-square"
                                                            style="color: green; font-size: 35px;"></i></button>
                                                    <button @click="removeOtherFeeItem(feeItem.id)"
                                                        style="background: none; border: none;"><i
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
        </div>
    </div>
</template>

<script setup>

import axios from "axios";
import { computed, onBeforeMount, onBeforeUnmount, onMounted, onUnmounted, reactive, ref, toRef, toRefs, watch } from "vue";
import { useToast } from "vue-toast-notification";

const props = defineProps({
    userInfo: {
        type: Object,
        required: true
    },
    add: {
        type: Boolean,
        required: true
    }
})
const dp = ref('')
const addModals = ref(null)
const addMore = ref(false)
const feeItems = reactive([
    { fee_type: 'Tuition', amount: 8000 },
    { fee_type: 'Registration', amount: 500 },
    { fee_type: 'Laboratory', amount: 2700 },
    { fee_type: 'Miscellaneous', amount: 2700 },
    // Add more fee items here as needed
])
const example = toRef(props, 'userInfo')
const state = ref({
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

const selectedPartitionText = ref('Semi Monthly Partition')
const model = reactive({
    fee: '',
    amount: ''
})
const otherFeeModel = reactive({
    fee: '',
    amount: '',
    student_id: '',
    school_year_semester: ''
})
const otherFeeId = ref('');
const errors = ref([])
const checkStudentData = ref(false);
const otherFeeData = ref([]);
const update = ref(false);
const checkData = ref([]);
const check = ref(false)
const partition = ref(false);
const downpayments = ref(false);
const changeAmount = (index) => {
    state.value.fee_type[index].amount = parseInt(event.target.value);

}
const removes = () =>{

    state.value.fee_type = [];

}
watch(props, async (newValue, oldValue) => {

    if (newValue.add) {
        await getOtherFee();
        await checkTuition()
        state.value.student_id = example.value.student_no;
        state.value.school_year_semester = example.value.school_year_semester
        state.value.student_name = example.value.first_name +' '+example.value.middle_name+'  '+example.value.last_name;
        otherFeeModel.school_year_semester = example.value.school_year_semester;
        otherFeeModel.student_id = example.value.student_no;

    }
})

// save fee Item
const saveFee = () => {
    state.value.fee_type.push({ fee_type: model.fee, amount: model.amount });
    model.amount = '';
    model.fee = '';
    addMore.value = false;

}
// add Downpayment
const saveDownPayment = (e) => {
    if (!!state.value.downpayment) return;
    state.value.downpayment = dp.value;
    dp.value = ''
    downpayments.value = false;


}
// remove fee Item
const removeFeeItem = (index) => {
    state.value.fee_type.splice(index, 1);
}
// close modal
const closeModal = () => {
    addModals.value.click()
    errors.value = '';
    // state.fee_type = [];
    state.value.selectedPartition = ''
    state.value.downpayment = ''
    selectedPartitionText.value = 'Semi Monthly Partition'

    otherFeeModel.amount = '';
    otherFeeModel.fee = '';

}

// compute all fee item
watch(state.value, (newItem, oldItems) => {
    var total = 0;
    newItem.fee_type.forEach(item => {

        total = parseInt(item.amount) + parseInt(total);
    })
    state.value.totalSchoolFee = total;
    if (state.value.downpayment == '') {
        state.value.Total_Payable_Fee = total;
    } else {

        state.value.Total_Payable_Fee = parseInt(total) - parseInt(state.value.downpayment)
    }

})

const selectPartition = (partition, text) => {
    state.value.selectedPartition = partition;
    selectedPartitionText.value = text;
}
computed(() => {

    if (this.selectedPartition === '') {
        return this.feeItems;
    } else {
        return this.feeItems.filter(item => item.type !== 'Downpayment');
    }


})

// ###############  backend function #######################

// cancel update
const cancelUpdate = () => {
    otherFeeId.value = '';
    otherFeeModel.amount = '';
    otherFeeModel.fee = '';
    update.value = false;
}



// fetch other fee
const getOtherFee = async () => {
    const res = await axios.post('/api/cashier/other/fee', { school_year_semester: example.value.school_year_semester, student_id: example.value.student_no })

    if (res.status == 200) {
        otherFeeData.value = res.data.get_fee_details.filter(value =>{
          value.amount = parseFloat(value.amount).toFixed(2);
          return value;
        });
    } else {
        otherFeeData.value = [];
    }
}

// edit other fee
const edit = (index) => {
    const value = otherFeeData.value[index];
    otherFeeId.value = value.id;
    otherFeeModel.amount = value.amount;
    otherFeeModel.fee = value.fee_type;
    update.value = true;
}

// delete other fee item
const removeOtherFeeItem = async (id) => {
    const res = await axios.delete('/api/cashier/other/fee/delete/' + id);
    getOtherFee()
}

// add student payment
const store = async () => {
    errors.value = []
    try {
        if (state.value.downpayment == "") {
            errors.value.push({ 'downpayment': true })
            downpayments.value = true;
        }


        if (state.value.selectedPartition == '') {
            errors.value.push({ 'selectedPartition': true })

            partition.value = true;
        }
        if (!errors.value[0]) {
            const { data } = await axios.post('/api/cashier/add/student_payment', state.value);
            closeModal();
            const $toast = useToast();
            let instance = $toast.success(`Created Successfully!`, {
                position: "top-right",
            });
            partition.value = false;
        }
    } catch (error) {
        checkStudentData.value = true
    }

}

// add other fee payment
const saveOtherFee = async () => {
    if (update.value) {
        const res = await axios.put('/api/cashier/update/other/student_payment/'+otherFeeId.value, otherFeeModel);

        otherFeeModel.amount = '';
        otherFeeModel.fee = '';
        getOtherFee()
    } else {
        const res = await axios.post('/api/cashier/add/other/student_payment', otherFeeModel);

        otherFeeModel.amount = '';
        otherFeeModel.fee = '';
        getOtherFee()
    }
}

// check if yung student is my tuition fee details na
const checkTuition = async () =>{
    const res = await axios.post('/api/cashier/check/student_details',{ school_year_semester: example.value.school_year_semester,
        student_id: example.value.student_no})
    if(res.status == 200)
    {

        state.value.fee_type = res.data.get_fee_details.filter(value =>{
            return value.fee_type != 'Downpayment';
        });
        selectedPartitionText.value = res.data.partition+'th monthly'
        const downpayment = res.data.get_fee_details.find(value =>{
            return value.fee_type == 'Downpayment';
        });
        state.value.downpayment = downpayment.amount;
        check.value = true;


    }else{
        state.value.fee_type = [
    { fee_type: 'Tuition', amount: 8000 },
    { fee_type: 'Registration', amount: 500 },
    { fee_type: 'Laboratory', amount: 2700 },
    { fee_type: 'Miscellaneous', amount: 2700 },
    // Add more fee items here as needed
];
        state.value.downpayment = 0;
        check.value = false;
        selectedPartitionText.value = 'Semi Monthly Partition';

    }
}
</script>

<style scoped></style>

