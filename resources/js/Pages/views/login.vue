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
                <small>Capstone Directory</small>
            </div>
            <form class="col-10">
                <InputText class="input-user-auth" placeholder="Email" />
                <Password
                    class="input-user-auth"
                    :feedback="false"
                    toggleMask
                    placeholder="Password"
                />
                <Button label="LOGIN" />
                <Link href="/forgot-password">
                    <small>Forgot Password?</small>
                </Link>
                <Link href="/register">
                    <small>Sign Up Here</small>
                </Link>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    name: "Login", // Make sure this is correctly named
    components: { Link },
};
</script>

<style></style>
