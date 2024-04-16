<template>
    <main class="d-flex justify-content-between">
        <div class="card col-4" style="height: fit-content;">
            <div class="card-header">
                Payment
            </div>
            <div class="card-body">
                <form @submit.prevent="store">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full name</label>
                        <input type="text" required v-model="state.fullname" class="form-control" id="fullname"
                            aria-describedby="emailHelp">

                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <input type="text" required v-model="state.remarks" class="form-control" id="remarks">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" required v-model="state.amount" step="0.01" class="form-control" id="amount">
                    </div>

                    <button v-if="update" type="submit" class="btn btn-success" style="margin-right: 2px;">Update</button>
                    <button v-if="update" type="button" @click="cancelUpdate" class="btn btn-danger">Cancel</button>
                    <button v-else type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="card col-7" >
            <div class="card-header">
                Others Fee Data
            </div>
            <div class="card-body" style="max-height: 450px;overflow-y: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Full name</th>
                            <th>Remarks</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fee in otherFees" :key="fee">
                            <td>{{ fee.fullname }}</td>
                            <td>{{ fee.remarks }}</td>
                            <td><i class="fa-solid fa-peso-sign"></i>{{ parseFloat(fee.amount).toLocaleString('en-US') }}</td>
                            <td>
                                <button @click="edit(fee.id)" class="btn  btn-sm btn-success "
                                    style="margin-right: 2px;">Update</button>
                                <button @click="destroy(fee.id)" class="btn  btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</template>
<script setup>
import axios from "axios";
import { onBeforeMount, reactive, ref } from "vue";
import { useToast } from "vue-toast-notification";
const alerts = useToast();
const update = ref(false);
const state = reactive({
    fullname: '',
    remarks: '',
    amount: '',
})
const otherFees = ref([]);
const ids = ref('');
const store = async () => {
    if(update.value)
    {
        const res = await axios.put('/api/cashier/other_payment/'+ids.value, state);
    state.fullname = '';
    state.remarks = '';
    state.amount = '';
    ids.value = '';
    update.value = false;
    fetch()
    alerts.success('Updated Successfully!', {
        'position': 'top-right'
    })
    }else{
        const res = await axios.post('/api/cashier/other_payment', state);
    state.fullname = '';
    state.remarks = '';
    state.amount = '';
    fetch()
    alerts.success('Created Successfully!', {
        'position': 'top-right'
    })
    }
}

const fetch = async () => {
    const { data } = await axios.get('/api/cashier/other_payments');
    otherFees.value = data;
}

const cancelUpdate = () =>{
    state.fullname = '';
    state.remarks = '';
    state.amount = '';
    update.value = false
}
const destroy = async (id) =>{
    await axios.delete('/api/cashier/other_payment/'+id)
    cancelUpdate();
    alerts.success('Deleted Successfully!', {
        'position': 'top-right'
    })
    fetch()
}
const edit = async (id) => {
    const updateValue = otherFees.value.find(value => {
        return value.id == id;
    })
    update.value = true;
    state.amount = updateValue.amount;
    state.remarks = updateValue.remarks;
    state.fullname = updateValue.fullname;
    ids.value = id;
}
onBeforeMount(() => {
    fetch()
})
</script>
