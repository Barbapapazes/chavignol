import type { Comment } from '@/blog/types/comment'
import type { Resource } from '@/blog/types/resource'

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
