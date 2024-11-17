import type { Reaction } from '@/blog/types/reaction'
import type { Resource } from '@/blog/types/resource'

export function getUserPostReactions(postId: number) {
  return baseApi<Resource<Reaction[]>>(`/api/user/posts/${postId}/reactions`, {
    method: 'GET',
  })
}
