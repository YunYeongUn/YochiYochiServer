<template>
    <div class="input-box">
        <!-- <h3 class="input-title" :class="{ 'title-danger': valids }"> -->
        <h3 class="input-title" :class="valids ? false : 'title-danger'">
            {{ names }}
        </h3>
        <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="input-item"
            :type="passwords ? 'password' : 'text'" :placeholder="placeholders" :class="{ 'input-danger': valids }" />
        <p v-show="valids ? false : true" class="input-error">
            {{ names }}을 정확히 입력해주세요.
        </p>
    </div>
</template>

<script>
export default {
    props: {
        names: String,
        placeholders: String,
        // v-model을 사용할 때 필요
        modelValue: {
            type: String
        },
        valids: {
            type: Boolean
        },
        passwords: Boolean
    },
    // v-model을 사용할 때 필요
    emits: ['update:modelValue'],
}
</script>

<style>
.input-error {
    line-height: 16px;
    font-size: 11px;
    color: red;
}

.title-normal {
    color: black;
}

.title-danger {
    color: red;
}

.input-danger {
    border-bottom: 1px solid red !important;
}
</style>