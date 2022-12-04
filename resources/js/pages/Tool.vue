<template>
  <div>

    <Head title="Reset Password" />

    <Heading class="mb-6">Reset Password</Heading>

    <Card>

        <div class="dark:text-white text-lg">

            <div class="divide-y divide-gray-100 dark:divide-gray-700">

                <div class="flex flex-col md:flex-row">
                    <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
                        <label for="currentPassword" class="inline-block pt-2 leading-tight text-sm">
                            Current Password <span class="text-red-500 text-sm">*</span>
                        </label>
                    </div>
                    <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 md:w-3/5 w-full md:py-5">
                        <div class="space-y-1">
                            <input type="password" v-model="current_password" class="w-full form-control form-input form-input-bordered" id="currentPassword" required>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row">
                    <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
                        <label for="password" class="inline-block pt-2 leading-tight text-sm">
                            New Password <span class="text-red-500 text-sm">*</span>
                        </label>
                    </div>
                    <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 md:w-3/5 w-full md:py-5">
                        <div class="space-y-1">
                            <input type="password" v-model="password" class="w-full form-control form-input form-input-bordered" id="password" required>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row">
                    <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
                        <label for="passwordConfirmation" class="inline-block pt-2 leading-tight text-sm">
                            Password Confirmation <span class="text-red-500 text-sm">*</span>
                        </label>
                    </div>
                    <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 md:w-3/5 w-full md:py-5">
                        <div class="space-y-1">
                            <input type="password" v-model="password_confirmation" class="w-full form-control form-input form-input-bordered" id="passwordConfirmation" required>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </Card>

    <div class="flex flex-col md:flex-row md:items-center justify-end space-y-2 md:space-y-0 space-x-3  mt-8">
      <button @click="resetPassword"
          type="submit"
          class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900"
      >
          <span>Save password</span>
      </button>

    </div>

  </div>
</template>

<script>

let Nova = window.Nova;

export default {

    name: 'ResetPasswordTool',

    props: {
        current_password: {
            type: String,
            required: true,
        },
        password: {
            type: String,
            required: true,
        },
        password_confirmation: {
            type: String,
            required: true,
        },
        min_password_length: {
            type: Number,
            required: true,
            default: Nova.config('minPasswordLength'),
        },
    },

    data() {
        return {
            current_password: '',
            password: '',
            password_confirmation: '',
            min_password_length: this.min_password_length,
        }
    },

    mounted() {
        this.min_password_length = Nova.config('minPasswordLength')
    },

    methods: {

        validate() {

            if (this.current_password.trim().length === 0) {
                Nova.error('Current password is required')
                return false;
            }

            if (this.password.trim().length === 0) {
                Nova.error('Password is required')
                return false;
            }

            if (this.password_confirmation.trim().length === 0) {
                Nova.error('Password confirmation is required')
                return false;
            }

            if (this.password.trim().length === 0 || this.password !== this.password_confirmation) {
                Nova.error('The password confirmation does not match.');
                return false;
            }

            if (this.password.trim().length > this.min_password_length) {
                console.log('not long enough')
                Nova.error('The password must be at least ' + this.min_password_length + ' characters.');
                return false;
            }

            return true;
        },

        resetPassword() {

            this.validate();

            Nova.request()
                .post('/nova-vendor/reset-password/nova-reset-password', {
                    current_password: this.current_password,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then(() => {

                    this.current_password = '';
                    this.password = '';
                    this.password_confirmation = '';

                    Nova.success('Password updated successfully');
                });
        }
    }
}
</script>
