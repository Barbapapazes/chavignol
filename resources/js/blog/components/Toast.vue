<script lang="ts" setup>
import type { Toast } from '@/blog/types/toast'

const props = defineProps<{
  toast: Toast
}>()

const el = ref()
const height = ref(0)

onMounted(() => {
  setTimeout(() => {
    height.value = el.value.$el.getBoundingClientRect()?.height
  }, 0)
})

const icon = computed(() => {
  switch (props.toast.type) {
    case 'success':
      return 'i-ph-check-circle-duotone text-green-500'
    case 'info':
      return 'i-ph-info-duotone text-blue-500'
    case 'trash':
      return 'i-ph-trash-duotone text-red-500'
    case 'error':
      return 'i-ph-x-circle-duotone text-red-500'
    case 'warning':
      return 'i-ph-warning-duotone text-yellow-500'
  }

  return ''
})

defineExpose({
  height,
})
</script>

<template>
  <ToastRoot
    ref="el"
    class="flex gap-2 rounded-md border border-neutral-200 bg-white p-4 shadow-sm"
    :style="{ '--height': height }"
  >
    <span v-if="icon" class="inline-block size-5" :class="icon" />
    <span v-else-if="toast.customIconText" class="mt-[2px] inline-block leading-none">
      {{ toast.customIconText }}
    </span>

    <div class="flex flex-col" :class="{ 'mt-px': icon }">
      <ToastTitle class="text-sm font-medium text-neutral-950">
        {{ toast.title }}
      </ToastTitle>
      <ToastDescription
        class="text-xs text-neutral-500"
      >
        {{ toast.description }}
      </ToastDescription>
    </div>

    <ToastClose
      aria-label="Close"
      class="text-neutral-500 transition duration-300 ease-out hover:text-neutral-800"
    >
      <span aria-hidden="true" class="i-ph-x-light absolute right-4 top-4 inline-block size-4" />
    </ToastClose>
  </ToastRoot>
</template>
