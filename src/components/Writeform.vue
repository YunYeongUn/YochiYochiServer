<template>
    <div class="container">
        <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :placeholder="placeholders"
            :maxlength="maxLength" />
        <p v-show="valids ? true : false" class="input-error">
            {{ names }}
        </p>
    </div>
</template>

<script>
export default {
    props: {
        names: String,
        maxLength: String,
        placeholders: String,
        // v-model을 사용할 때 필요
        modelValue: {
            type: String
        },
        passwords: Boolean
    },
    // v-model을 사용할 때 필요
    emits: ['update:modelValue'],
    data() {
        return {

        }
    }
}
</script>

<style></style>

