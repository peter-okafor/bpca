import { configureStore } from '@reduxjs/toolkit';
import providerDetailsReducer from '@/Pages/Frontend/Details/detailsSlice'; //'@/pages/frontend/details/detailsSlice'
import searchReducer from '@/Pages/Frontend/Search/searchSlice';
import homeReducer from '@/Pages/Frontend/Home/homeSlice';
// ...

export const store = configureStore({
  reducer: {
    providerDetail: providerDetailsReducer,
    providersList: searchReducer,
    search: homeReducer
  },
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch