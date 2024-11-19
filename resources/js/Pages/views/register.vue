<template>
    <div class="user-auth">
        <div class="user-auth-box col">
            <div class="header">
                <div class="logo">
                    <img
                        src="https://res.cloudinary.com/drayixmpk/image/upload/v1731331390/cics-logo_dmrh8v.png"
                        alt="ust-cics-logo"
                    />
                </div>
                <p>UST-CICS</p>
                <small>Register</small>
            </div>
            <form @submit.prevent="submitForm" class="col-10">
                <InputText
                    v-model="registerForm.first_name"
                    class="input-user-auth"
                    placeholder="First Name"
                />
                <InputText
                    v-model="registerForm.last_name"
                    class="input-user-auth"
                    placeholder="Last Name"
                />
                <!-- <InputText
                    v-model="registerForm.studentNumber"
                    class="input-user-auth"
                    placeholder="Student Number"
                /> -->
                <InputText
                    v-model="registerForm.email"
                    class="input-user-auth"
                    placeholder="Email"
                />
                <Select
                    v-model="registerForm.user_course"
                    :options="courses"
                    optionLabel="name"
                    optionValue="value"
                    class="input-user-auth"
                    placeholder="Select Course"
                />
                <Password
                    v-model="registerForm.password"
                    class="input-user-auth"
                    :feedback="false"
                    toggleMask
                    placeholder="Password"
                />
                <Password
                    v-model="registerForm.password_confirmation"
                    class="input-user-auth"
                    :feedback="false"
                    toggleMask
                    placeholder="Confirm Password"
                />
                <Button
                    label="REGISTER"
                    type="submit"
                    :loading="isLoading"
                    @click="submitForm"
                />
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    name: "Login", // Make sure this is correctly named
    components: { Link },
    data() {
        return {
            registerForm: useForm({
                first_name: null,
                last_name: null,
                studentNumber: null,
                email: null,
                user_course: null,
                password: null,
                password_confirmation: null,
            }),
            courses: [
                {
                    name: "Computer Science",
                    value: "CS",
                },
                {
                    name: "Information Technology",
                    value: "IT",
                },
                {
                    name: "Information Systems",
                    value: "IS",
                },
            ],
            isLoading: false,
        };
    },
    methods: {
        async submitForm() {
            this.isLoading = true; // Set loading state to true when submission starts

            try {
                // Post the form data using Inertia's useForm
                await this.registerForm.post("/register", {
                    onFinish: () => {
                        // Handle actions after form submission (success or failure)
                        console.log("Form submitted");
                    },
                    onError: (errors) => {
                        // Handle form validation errors
                        console.log(errors);
                    },
                });
            } catch (error) {
                console.error(
                    "An error occurred during form submission:",
                    error
                );
            } finally {
                this.isLoading = false; // Reset loading state when submission is finished
            }
        },
    },
};
</script>

<style></style>
