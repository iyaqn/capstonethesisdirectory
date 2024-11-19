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
        <small>Reset Password</small>
      </div>
      <form class="col-10">
        <Password
          class="input-user-auth"
          :feedback="false"
          toggleMask
          placeholder="Password"
        />
        <Password
          class="input-user-auth"
          :feedback="false"
          toggleMask
          placeholder="Confirm Password"
        />
        <Button label="RESET" />
      </form>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style></style>
