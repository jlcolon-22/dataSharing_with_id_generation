<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Add Student Information
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" :key="statePath">
                        <!-- image display from public folder -->
                        <!-- its working -->
                        <!-- <img :src="image_src"> -->
                        <!-- {{ statePath }} -->
                        <!-- Student Info -->
                        <div class="row">
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
                                    <label for="message-text" class="col-form-label fw-bold">Middle Name:</label>
                                    <br />
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.middle_name
                                    }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label fw-bold">First Name:</label>
                                    <br />
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.first_name }}</label>
                                </div>
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
                        <!-- Guardian's Info -->
                        <h5 class="modal-title" id="exampleModalLabel">
                            Guardian's Information
                        </h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label fw-bold">Guardian's Name:</label>
                                    <br />
                                    <label for="recipient-name" class="col-form-label">{{ userInfo.guardian_name
                                    }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-labe fw-bold">Guardian's Address:</label>
                                    <br />
                                    <label for="recipient-name" class="col-form-label">{{
                                        userInfo.guardian_address
                                    }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label fw-bold">Guardian's Contact:</label>
                                    <br />
                                    <label for="recipient-name" class="col-form-label">{{
                                        userInfo.guardian_contact_no
                                    }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <i class="fa-solid fa-thumbtack thumbtack-icon"></i>
                                    <div class="card-header">
                                        <h6 class="ms-3 text-light">
                                            Identification Card Picture
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center">
                                            <img :key="stateInit" :src="capturedImage" alt="" style="
                                                    background-color: white;
                                                    width: 150px;
                                                    height: 150px;
                                                " />
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                                <i class="fa-solid fa-upload me-2"></i>Upload Picture
                                            </button>
                                            <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal"
                                                data-bs-target="#cameraModal">
                                                <i class="fa-solid fa-camera me-2"></i>Use Camera
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <i class="fa-solid fa-thumbtack thumbtack-icon"></i>
                                    <div class="card-header">
                                        <h6 class="ms-3 text-light">
                                            Identification Card Signature
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center" style=" width: 150px;
                                                    height: 150px; margin: 0 auto; display: flex;align-items: center;" :key="stateInit">
                                            <img :src="signatureImage" alt="" style="
                                                    background-color: white;
                                                    height:39.637481689453125px;width: 44.6624755859375px;
                                                " />
                                        </div>
                                        <!--  -->
                                        <div class="mt-3">
                                            <button class="btn btn-success w-100 mb-3" type="file" data-bs-toggle="modal" data-bs-target="#uploadSignatureModal">
                                                <i class="fa-solid fa-upload me-2"></i>Upload Signature
                                            </button>
                                            <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal"
                                                data-bs-target="#signatureModal">
                                                <i class="fa-solid fa-signature me-2"></i>Signature Pad
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- camera modal -->
    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Capture Profile
                    </h5>
                    <button type="button"   class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body col-md-12">
                    <!-- Student Profile -->
                    <div class="container row">
                        <video ref="video" autoplay class="col-sm-6">
                            Stream unavailable
                        </video>

                        <div class="col-sm-6">
                            <div class="card border-0 image-container">
                                <img :src="capturedImage" alt="" class="centered-image" id="capture-img" />
                                <!-- <Editor :canvasWidth="canvasWidth" :canvasHeight="canvasHeight" ref="editor" editorId="canvasId"/> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                            <video ref="video" autoplay>Stream unavailable</video>
                        </div> -->
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary text-center" @click="captureImage()">
                        <i class="fa-solid fa-id-card"></i> Capture
                    </button>

                    <button class="btn btn-secondary text-center" @click="saveCroppedImage">
                        <i class="fa-solid fa-id-card"></i> Save
                    </button>
                </div>
            </div>
        </div>
        <!-- Display Captured Image -->
        <!-- <img :src="capturedImage" alt="" style="background-color: white; width: 150px; height: 150px;"> -->
    </div>
    <!-- camera modal -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Write your Signature
                    </h5>
                    <button type="button" @click="$emit('close')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body col-md-12">
                    <!-- Student Profile -->
                    <div class="conatiner row">
                        <div class="col-sm-6">
                            <!-- :w="'1280px'" :h="'400px'" -->
                            <Vue3Signature ref="signature1" :sigOption="state.option" :w="'500px'" :h="'300px'"
                                :disabled="state.disabled" class="signature border"></Vue3Signature>
                        </div>

                        <div class="col-sm-6">
                            <div class="card border-0 image-container">
                                <img :src="signatureImage" alt="" class="centered-image" id="capture-img" />
                                <!-- <Editor :canvasWidth="canvasWidth" :canvasHeight="canvasHeight" ref="editor" editorId="canvasId"/> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                            <video ref="video" autoplay>Stream unavailable</video>
                        </div> -->
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary text-center" @click="clear">
                        <i class="fa-solid fa-eraser"></i> Clear
                    </button>
                    <button class="btn btn-secondary text-center" @click="undo">
                        <i class="fas fa-undo"></i> Undo
                    </button>
                    <button class="btn btn-success text-center" @click="save('image/jpeg')">
                        <i class="fa-solid fa-id-card"></i> Save
                    </button>
                    <!-- <button
                        class="btn btn-secondary text-center"
                        @click="saveCroppedImage"
                    >
                        <i class="fa-solid fa-id-card"></i> Save
                    </button> -->
                </div>
            </div>
        </div>
        <!-- Display Captured Image -->
        <!-- <img :src="capturedImage" alt="" style="background-color: white; width: 150px; height: 150px;"> -->
    </div>
    <!-- modal upload image -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-xl " style="width: 400px;">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                       Upload Image
                    </h5>
                    <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body col-md-12">
                    <form @submit.prevent="storeUploadImage">
                        <label for="">File:</label>
                        <input type="file" ref="imageFile" @change="uploadImage" class="form-control">
                        <button class="btn btn-success text-center mt-4 w-100" >
                        Upload Image
                    </button>
                    </form>
                </div>

            </div>
        </div>
        <!-- Display Captured Image -->
        <!-- <img :src="capturedImage" alt="" style="background-color: white; width: 150px; height: 150px;"> -->
    </div>
    <!-- modal upload signature -->
    <div class="modal fade" id="uploadSignatureModal" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-xl " style="width: 400px;">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                       Upload Signature
                    </h5>
                    <button type="button"  class="btn-close" data-bs-dismiss="modal" @click="$emit('close')" aria-label="Close"></button>
                </div>
                <div class="modal-body col-md-12">
                    <form @submit.prevent="storeUploadSignature">
                        <label for="">File:</label>
                        <input type="file" ref="imageFileSignature" @change="uploadSignature" class="form-control">
                        <button class="btn btn-success text-center mt-4 w-100" >
                        Upload Image
                    </button>
                    </form>
                </div>

            </div>
        </div>
        <!-- Display Captured Image -->
        <!-- <img :src="capturedImage" alt="" style="background-color: white; width: 150px; height: 150px;"> -->
    </div>

    <!-- components recieved props -->
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch, reactive ,defineProps} from "vue";
import "cropperjs/dist/cropper.css";
import Cropper from "cropperjs";
import axios from "axios";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
const props = defineProps(['userInfo','upload'])

const cropper = ref(null)
const studentDetails = ref([]);
const video = ref(null);
let mediaStream = null;
// accessing public folder in laravel
const capturedImage = ref("/id_image/man.png"); // Initialize the captured image URL
const profileImage = ref('')
const signatureImage = ref('')
// accessing public folder in laravel

const stateI = ref(0);
const stateInit = ref(0);

const width = ref('')
const height = ref('')
const file = ref('');
const fileSignature = ref('');
const imageFile = ref(null);
const imageFileSignature = ref(null);

// for signature
const state = reactive({
    count: 0,
    option: {
      penColor: "rgb(0,0,0)",
      backgroundColor: "rgb(255,255,255)"

    },
    disabled: false
})

const signature1 = ref(null)

const save = (t) => {
    signatureImage.value = signature1.value.save(t)

    // Create an image element
    const image = new Image();
    // Set the base64-encoded data as the image source
    image.src = signatureImage.value;
    image.style.backgroundColor  = 'red'
    // Wait for the image to load
    image.onload = () => {
        // Create a new canvas with the desired dimensions
        const targetCanvas = document.createElement("canvas");
        const targetContext = targetCanvas.getContext("2d");
        targetCanvas.width = image.width;
        targetCanvas.height = image.height;
        console.log(targetCanvas.width)
        console.log(targetCanvas.height)

        // Draw the image onto the target canvas
        targetContext.drawImage(
            image,
            0,
            0
        );

        // Convert the resized canvas to a blob
        targetCanvas.toBlob((blob) => {
            const formData = new FormData();
            formData.append(
                "signatureImage",
                blob,
                `${props.userInfo.student_no}.png`
            );
            formData.append('student_id',props.userInfo.student_no)
                formData.append('school_year_semester',props.userInfo.school_year_semester)
                formData.append('type',0)

            // Send the resized image to the Laravel API endpoint
            axios
                .post("/api/save-signature-image", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    // Handle the response from the server
                    console.log(response.data);
                    const $toast = useToast();

                    let instance = $toast.success('Upload Successfully!', { position: 'bottom-right' });
                })
                .catch((error) => {
                    // Handle any errors
                    console.error(error);
                });
        }, "image/png");


        console.log(signature1.value.save(t))
    }
}

const clear = () => {
    // signatureImage.value.clear()
    signature1.value.clear()
}

const undo = () => {

    signature1.value.undo();
}

watch(props,async(v,o)=>{
    if(v.upload)
    {
        clear();
        capturedImage.value = "/id_image/man.png";
        await fetchStudentSasoRecord()
    }
})
// get student Saso record
const fetchStudentSasoRecord = async () =>{
    const res = await axios.post('/api/saso/student/details',{school_year_semester:props.userInfo.school_year_semester,student_id:props.userInfo.student_no})

    if(res.status == 200)
    {
        studentDetails.value = res.data;
        capturedImage.value = res.data.image ? 'storage/studentImage/'+res.data.image : '/id_image/sample.jpg' ;
        signatureImage.value = res.data.signature ? 'storage/signature/'+res.data.signature : '/id_signatures/sample.png';

    }else{
        studentDetails.value = [];
        capturedImage.value = '/id_image/sample.jpg'
      signatureImage.value = '/id_signatures/sample.png';
    }
}
// upload profile image
const storeUploadImage = async () =>{
    const formData = new FormData();
                formData.append(
                    "croppedImage",file.value);
                formData.append('student_id',props.userInfo.student_no)
                formData.append('school_year_semester',props.userInfo.school_year_semester)

                // Send the resized image to the Laravel API endpoint
                axios
                    .post("/api/save-cropped-image", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        // Handle the response from the server
                        console.log(response.data);
                        stateI.value = response.data.id
                        const $toast = useToast();
                        imageFile.value.value = ''
                        let instance = $toast.success('Updated Successfully!', { position: 'bottom-right' });
                        // Update stateInit after a successful response
                        fetchStudentSasoRecord()
                        // localStorage.setItem('student_no',responseData.value.student_no)

                    })
                    .catch((error) => {
                        // Handle any errors
                        console.error(error);
                    });
}

const storeUploadSignature = async () =>{
    const formData = new FormData();
            formData.append(
                "signatureImage",
                fileSignature.value
            );
            formData.append('student_id',props.userInfo.student_no)
                formData.append('school_year_semester',props.userInfo.school_year_semester)
                formData.append('type',1)

            // Send the resized image to the Laravel API endpoint
            axios
                .post("/api/save-signature-image", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    // Handle the response from the server

                    const $toast = useToast();
                    imageFileSignature.value.value = '';
                    let instance = $toast.success('Upload Successfully!', { position: 'bottom-right' });
                })
                .catch((error) => {
                    // Handle any errors
                    console.error(error);
                });
}

const uploadImage= (e) =>{
    file.value = e.target.files[0];
}

const uploadSignature= (e) =>{
    fileSignature.value = e.target.files[0];
}


onMounted(async () => {
    // Listen to the modal shown and hidden events
    const cameraModal = document.getElementById("cameraModal");
    cameraModal.addEventListener("shown.bs.modal", startCapture);
    cameraModal.addEventListener("hidden.bs.modal", stopCapture);
});

onUnmounted(() => {
    // // Cleanup: remove event listeners and stop camera
    // const cameraModal = document.getElementById("cameraModal");
    // cameraModal.removeEventListener("shown.bs.modal", startCapture);
    // cameraModal.removeEventListener("hide.bs.modal", stopCapture);
    // stopCapture();
    // Cleanup: remove event listeners and stop camera
    const cameraModal = document.getElementById("cameraModal");
    if (cameraModal) {
        cameraModal.removeEventListener("shown.bs.modal", startCapture);
        cameraModal.removeEventListener("hide.bs.modal", stopCapture);
        stopCapture();
    }
});

// Start the camera when the camera modal is shown
const startCapture = () => {
    navigator.mediaDevices
        .getUserMedia({ video: true, audio: false })
        .then((stream) => {

            video.value.srcObject = stream;
            mediaStream = stream;
        })
        .catch((err) => {
            console.log(err);
        });
};

const stopCapture = () => {
    if (mediaStream) {
        mediaStream.getTracks().forEach((track) => {
            track.stop();
        });
        mediaStream = null;
    }
};

const captureImage = () => {
    const canvas = document.createElement("canvas");
    const context = canvas.getContext("2d");
    canvas.width = video.value.videoWidth;
    canvas.height = video.value.videoHeight;
    context.drawImage(video.value, 0, 0, canvas.width, canvas.height);
    const imageSrc = canvas.toDataURL("image/jpeg");

    // Update the capturedImage data property
    capturedImage.value = imageSrc;
    // console.log(imageSrc)
    // console.log(stream)

    // crop images
    const imageCropElement = document.getElementById("capture-img");
    // Retrieve the existing Cropper instance or create a new one
    // cropper = imageCropElement._cropper;
    if (!cropper.value) {
        // // If an existing Cropper instance exists, destroy it
        // cropper.destroy();
        // Set the new image source
        imageCropElement.src = imageSrc;

        // Create a new Cropper instance
        cropper.value = new Cropper(imageCropElement,{
            aspectRatio:0,
            viewMode:0,
            cropBoxResizable:false,
            crop(event)
            {

                width.value = event.detail.width;
                height.value = event.detail.height;

            }
        });
    } else {
        // Replace the image within the existing Cropper instance
        cropper.value.replace(imageSrc);
    }



    stopCapture();
    // Save the cropped image to the server
    // saveCroppedImage(imageCropElement);

    startCapture();
};

const saveCroppedImage = () => {

    if (!!cropper.value) {
        const canvas = cropper.value.getCroppedCanvas();
        console.log(canvas)
        if (canvas) {
            // Resize the canvas
            const resizedCanvas = document.createElement("canvas");
            const resizedContext = resizedCanvas.getContext("2d");
            resizedCanvas.width = width.value;
            resizedCanvas.height = height.value;
            resizedContext.drawImage(canvas, 0, 0, width.value, height.value);

            // Convert the resized canvas to a blob
            resizedCanvas.toBlob((blob) => {

                const formData = new FormData();
                formData.append(
                    "croppedImage",
                    blob,
                    `${props.userInfo.student_no}.png`
                );
                formData.append('student_id',props.userInfo.student_no)
                formData.append('school_year_semester',props.userInfo.school_year_semester)

                // Send the resized image to the Laravel API endpoint
                axios
                    .post("/api/save-cropped-image", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        // Handle the response from the server
                        console.log(response.data);
                        stateI.value = response.data.id
                        const $toast = useToast();
                        let instance = $toast.success('Updated Successfully!', { position: 'bottom-right' });
                        // Update stateInit after a successful response
                        fetchStudentSasoRecord()
                        // localStorage.setItem('student_no',responseData.value.student_no)

                    })
                    .catch((error) => {
                        // Handle any errors
                        console.error(error);
                    });
            }, "image/png");
        }
    }
};
</script>

<style scoped>
/* signature */
.signature {
    margin: 0 auto;
}

/* image */
img {
    display: block;

    /* This rule is very important, please don't ignore this */
    max-width: 100%;
}

.image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    /* Add any other necessary styles */
}

.centered-image {
    background-color: white;
    /* width: 250px;
  height: 250px; */
    /* border: 1px solid red; */
    /* Add any other necessary styles */
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
}

.btn-view {
    width: 100%;
}

/* Card Design */
.card-header {
    background-color: rgb(57, 157, 199);
}

/* Thumbtack Icon Design */
.thumbtack-icon {
    color: #ffffff;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: -3px;
    left: 10px;
    z-index: 1;
}
</style>
