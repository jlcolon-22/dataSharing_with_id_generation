<template>
    <section>
        <div class="main">
            <!-- Modal -->
            <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl ">
                    <form @submit.prevent="update" method="put" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Information Details</h5>
                            <button type="button" class="btn-close" @click="$emit('close')"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Student Info -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Full Name:</label>
                                        <input type="text" class="form-control" :placeholder="userInfo.first_name + ' '+ userInfo.last_name" disabled>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Year / Semester:</label>
                                        <input type="text" class="form-control" id="recipient-name"
                                            :placeholder="userInfo.school_year_semester" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Date:</label>
                                        <input type="date" disabled class="form-control" v-model="state.date" id="recipient-name">
                                    </div>
                                </div>

                            </div>
                            <!-- Other Info -->
                            <div class="row">
                            </div>
                            <h5 class="modal-title" id="exampleModalLabel">Prescription</h5>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Vitals Sign:</label>
                                        <div class="row">

                                            <div class="col">
                                                Temperature
                                                <input type="number" step="0.01" v-model="state.temp" class="form-control"
                                                    id="temp-input">
                                            </div>
                                            <div class="col">
                                                Blood Pressure
                                                <input type="text" v-model="state.bp" class="form-control" id="bp-input">
                                            </div>
                                            <div class="col">
                                                Respiratory Rate
                                                <input type="number" v-model="state.rr" class="form-control" id="rr-input">
                                            </div>
                                            <div class="col">
                                                Pulse Rate
                                                <input type="number" v-model="state.pr" class="form-control" id="pr-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Chief Complaint</label>
                                        <textarea class="form-control" v-model="state.chief_complain"
                                            id="message-text"></textarea>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Management / Medication
                                            Given:</label>
                                        <textarea class="form-control" v-model="state.medication_given"
                                            id="message-text"></textarea>
                                    </div>
                                </div>
                                s
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-secondary"  @click="$emit('close')">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { toRef, watch, reactive } from "vue"
import {useToast} from 'vue-toast-notification'
import moment from "moment";
import axios from "axios";
const props = defineProps(['editrecordvalue', 'edit', 'userInfo'])
const emit = defineEmits(['close']);
const newProps = toRef(props, 'editrecordvalue')
const state = reactive({
    student_id: '',
    school_year_semester: '',
    student_name: '',
    date: '',
    section: '',
    temp: '',
    bp: '',
    rr: '',
    pr: '',
    chief_complain: '',
    medication_given: '',
    adviser:''
})
watch(props, (newValue, oldValue) => {
    if (newValue.edit) {

        state.bp = newProps.value.bp;
        state.temp = newProps.value.temp;
        state.rr = newProps.value.rr;
        state.pr = newProps.value.pr;
        state.chief_complain = newProps.value.chief_complain;
        state.medication_given = newProps.value.medication_given;
        state.adviser = newProps.value.adviser;
        state.student_id = newValue.userInfo.student_no;
        state.student_name = `${newProps.value.first_name} ${newProps.value.middlename} ${newProps.value.lastname}`;
        state.school_year_semester = newValue.userInfo.school_year_semester;
        state.date = moment(newProps.value.created_at).format('YYYY-MM-DD');
    }
})

const update = async () => {

    const res = await axios.put('/api/clinic/record/'+newProps.value.id+'/update' , state);
    emit('close')
    const $toast = useToast();
                let instance = $toast.success(`Update Successfully!`, {
                    position: "top-right",
                });
}
</script>
<style >
.main {
    background: red;

}

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

