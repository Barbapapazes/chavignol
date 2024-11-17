<script lang="ts" setup>
import type { Comment } from '@/blog/types/comment'

defineProps<{
  comment: Comment
}>()
</script>

<template>
  <div>
    {{ comment.content }}
  </div>
</template>
