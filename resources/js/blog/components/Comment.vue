<script lang="ts" setup>
import type { Comment } from '@/blog/types/comment'

defineProps<{
  comment: Comment
}>()

const emits = defineEmits<{
  delete: [void]
}>()

function onDelete() {
  emits('delete')
}
</script>

<template>
  <div class="flex flex-row gap-8">
    <p>
      {{ comment.content }}
    </p>

    <button class="rounded border border-neutral-200 px-2 py-1 text-sm tracking-wide text-neutral-700 shadow-sm transition duration-200 ease-in hover:border-neutral-400 hover:text-neutral-900" @click="onDelete">
      Delete
    </button>
  </div>
</template>
