import type { Comment } from '@/blog/types/comment'
import type { Reaction, ReactionCount } from '@/blog/types/reaction'
import type { Resource } from '@/blog/types/resource'

export function getEmoji(postId: number) {
  return baseApi<Resource<ReactionCount[]>>(`/api/posts/${postId}/reactions`, {
    method: 'GET',
  })
}

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

export function getComments(postId: number) {
  return baseApi<Resource<Comment[]>>(`/api/posts/${postId}/comments`, {
    method: 'GET',
  })
}

export function storePostComment(postId: number, content: string) {
  return baseApi<Resource<Comment>>(`/api/posts/${postId}/comments`, {
    method: 'POST',
    body: {
      content,
    },
  })
}

export function deletePostComment(postId: number, commentId: number) {
  return baseApi<void>(`/api/posts/${postId}/comments/${commentId}`, {
    method: 'DELETE',
  })
}
