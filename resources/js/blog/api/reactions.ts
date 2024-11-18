import type { Reaction } from '@/blog/types/reaction'
import type { Resource } from '@/blog/types/resource'

export function storeReaction(postId: number, emojiId: number) {
  return baseApi<Resource<Reaction>>(`/api/posts/${postId}/reactions`, {
    method: 'POST',
    body: {
      emoji_id: emojiId,
    },
  })
}

export function deleteReaction(postId: number, reactionId: number) {
  return baseApi<void>(`/api/posts/${postId}/reactions/${reactionId}`, {
    method: 'DELETE',
  })
}
