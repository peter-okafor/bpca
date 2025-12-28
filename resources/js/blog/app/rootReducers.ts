import bookmarkReducer from "./bookmarks/bookmarksSlice";
import postLikesReducer from "./postLikes/postLikes";
import commentLikesReducer from "./commentLikes/commentLikes";
import darkmodeReducer from "./darkmode/darkmode";
import pagesReducer from "./pages/pages";
import mediaRunningReducer from "./mediaRunning/mediaRunning";
import providerDetailsReducer from '@/Pages/Frontend/Details/detailsSlice'; //'@/pages/frontend/details/detailsSlice'
import searchReducer from '@/Pages/Frontend/Search/searchSlice';
import homeReducer from '@/Pages/Frontend/Home/homeSlice';

const rootReducers = {
  bookmark: bookmarkReducer,
  postLike: postLikesReducer,
  darkmode: darkmodeReducer,
  commentLikes: commentLikesReducer,
  pages: pagesReducer,
  mediaRunning: mediaRunningReducer,
  providerDetail: providerDetailsReducer,
  providersList: searchReducer,
  search: homeReducer
};

export default rootReducers;
