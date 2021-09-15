<template>
  <div id="create-user">
    <img src="" alt="로고" class="logo">

    <form class="form type01" @submit.prevent="login" @keyup="form.clearErrors()">
      <div class="input-wrap mt-normal">
        <div class="input-text type01">
          <input type="text" placeholder="닉네임" v-model="form.name">
        </div>

        <p class="input-error type01" v-if="form.errors.name">{{ form.errors.name }}</p>
      </div>

      <div class="input-wrap mt-normal">
        <div class="input-text type01">
          <input type="text" placeholder="이메일 아이디" v-model="form.email">
        </div>

        <p class="input-error type01" v-if="form.errors.email">{{ form.errors.email }}</p>
      </div>

      <div class="input-wrap mt-normal">
        <div class="input-text type01">
          <input type="password" placeholder="비밀번호" v-model="form.password">
        </div>
        <p class="input-error type01" v-if="form.errors.password">{{ form.errors.password }}</p>
      </div>

      <div class="input-wrap mt-normal">
        <div class="input-text type01">
          <input type="password" placeholder="비밀번호 확인" v-model="form.password_confirmation">
        </div>

        <p class="input-error type01" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</p>
      </div>

      <button class="btn type01">회원가입</button>
    </form>

  </div>
</template>
<script>
export default {
  data() {
    return {
      form: this.$inertia.form({
        email: null,
        name: null,
        password: null,
        password_confirmation: null
      })
    }
  },

  methods: {
    login() {
      this.form.post("/users");
    }
  }
}
</script>