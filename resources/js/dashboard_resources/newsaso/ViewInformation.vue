<template>
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header " style=" background-color: rgb(95, 178, 95);">
                    <h5 class="modal-title text-light">View Student Information</h5>
                    <button type="button" class="btn-close" @click="$emit('close')" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div v-show="check == true" class="alert alert-warning">
                        <strong>You need to upload a profile image and signature before you can start using these
                            features.!</strong>
                    </div>
                    <!-- Student Info -->
                    <div v-if="check == false" class="row mb-3">
                        <div class="col">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label fw-bold">Student Number:</label>
                                <br />
                                <label for="recipient-name" class="col-form-label">{{ userInfo.student_no }}</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label fw-bold">Last Name:</label>
                                <br />
                                <label for="recipient-name" class="col-form-label">{{ userInfo.last_name }}</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label fw-bold">Middle Name:</label>
                                <br />
                                <label for="recipient-name" class="col-form-label">{{ userInfo.middle_name }}</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label fw-bold">First Name:</label>
                                <br />
                                <label for="recipient-name" class="col-form-label">{{ userInfo.first_name }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label fw-bold">Course</label>
                                    <br />
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.course }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label fw-bold">Type</label>
                                    <br />
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.college }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian's Info -->
                    <h5 v-if="check == false"  class="modal-title" id="exampleModalLabel" style="color: rgb(67, 155, 67)">
                        Guardian's Information
                    </h5>
                    <div v-if="check == false"  class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label fw-bold">Guardian's Name:</label>
                                <br />
                                <label for="recipient-name" class="col-form-label">{{ userInfo.guardian_name }}</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="message-text" class="col-form-labe fw-bold mt-2">Guardian's Address:</label>
                                <br />
                                <label for="recipient-name" class="col-form-label">{{ userInfo.guardian_address }}</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="message-text" class="col-form-labe fw-bold mt-2">Guardian's Contact:</label>
                                <br />
                                <label for="recipient-name" class="col-form-label">{{ userInfo.guardian_contact_no
                                }}</label>
                            </div>
                        </div>
                    </div>
                    <div v-if="check == false"  class="row">
                        <div class="col-md-6">
                            <div class="card">

                                <div class="card-header bg-info">

                                    <h6 class=" text-light">
                                        <i class="fa-solid fa-thumbtack thumbtack-icon"></i> Identification Card Picture
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <img class="text-danger"
                                            style="width: 150px;height: 150px; object-fit: cover;object-position: top;"
                                            :src="profileImages" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">

                                <div class="card-header bg-info">
                                    <h6 class=" text-light">
                                        <i class="fa-solid fa-thumbtack thumbtack-icon"></i> Identification Card Signature
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center" style=" width: 150px;
                                                    height: 150px; margin: 0 auto; display: flex;align-items: center;">
                                        <img class="text-danger"
                                            style="height:39.637481689453125px;width: 44.6624755859375px; "
                                            :src="signatureImages" />
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
</template>
<script setup>
import axios from 'axios';
import { watch, ref } from 'vue';
const profileImages = ref('');
const signatureImages = ref('');
const check = ref(true);
const props = defineProps(['userInfo', 'view']);

watch(props, async (v, o) => {
    if (v.view) {
        await fetchStudentSasoRecord();
    }
})
// get student Saso record
const fetchStudentSasoRecord = async () => {
    const res = await axios.post('/api/saso/student/details', { school_year_semester: props.userInfo.school_year_semester, student_id: props.userInfo.student_no })

    if (res.status == 200) {
        check.value = false;
        profileImages.value = !!res.data.image ? 'storage/studentImage/' + res.data.image : check.value = true;
        signatureImages.value = !!res.data.signature ? 'storage/signature/' + res.data.signature : check.value = true;;


    } else {
        check.value = true;
        profileImages.value = '/id_image/sample.jpg'
        signatureImages.value = '/id_image/man.png';
    }
}
</script>
