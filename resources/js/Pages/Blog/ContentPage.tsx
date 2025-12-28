import React, { FC, ReactNode } from "react";
import { PostDataType, TaxonomyType } from "@blog/data/types";
import { SINGLE } from "@blog/data/single";
import SingleContent from "@blog/containers/PageSingle/SingleContent";
import { CommentType } from "@blog/components/CommentCard/CommentCard";
import SingleRelatedPosts from "@blog/containers/PageSingle/SingleRelatedPosts";
import { Sidebar } from "@blog/containers/PageSingle/Sidebar";
import SingleHeader from "@blog/containers/PageSingle/SingleHeader";
import MainTemplate from "./Template/MainTemplate";
import { Head } from "@inertiajs/inertia-react";
import { SinglePageType } from "@/blog/containers/PageSingle/PageSingle";

export interface PageSingleTemp3SidebarProps {
  className?: string;
  title?: string;
  post: SinglePageType;
  categories: TaxonomyType[];
  posts: PostDataType[];
  relatedPosts?: PostDataType[];
}

const ContentPage: FC<PageSingleTemp3SidebarProps> = ({
  className = "",
  title = "Page",
  post,
  categories,
  posts,
  relatedPosts
}) => {

  return (
    <MainTemplate>
      <div
        className={`nc-PageSingleTemp3Sidebar ${className}`}
        data-nc-id="PageSingleTemp3Sidebar"
      >
        {title && (
            <Head title={title} />
        )}
        <header className="relative pt-16 z-10 md:py-20 lg:py-28 bg-neutral-900 dark:bg-black">
          {/* SINGLE HEADER */}
          <div className="dark container relative z-10">
            <div className="max-w-screen-md">
              <SingleHeader
                hiddenDesc
                metaActionStyle="style2"
                pageData={post}
              />
            </div>
          </div>

          {/* FEATURED IMAGE */}
          <div className="mt-8 md:mt-0 md:absolute md:top-0 md:right-0 md:bottom-0 md:w-1/2 lg:w-2/5 2xl:w-1/3">
            <div className="hidden md:block absolute top-0 left-0 bottom-0 w-1/5 from-neutral-900 dark:from-black bg-gradient-to-r"></div>
            {/* <img
              className="block w-full h-full object-cover"
              src="https://images.unsplash.com/photo-1554941068-a252680d25d9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80"
              alt=""
            /> */}
          </div>
        </header>

        {/* SINGLE MAIN CONTENT */}
        <div className="container flex flex-col my-10 lg:flex-row ">
          <div className="w-full lg:w-3/5 xl:w-2/3 xl:pr-20">
            <SingleContent data={post} />
          </div>
          <div className="w-full mt-12 lg:mt-0 lg:w-2/5 lg:pl-10 xl:pl-0 xl:w-1/3">
            <Sidebar
                posts={posts}
                categories={categories}
            />
          </div>
        </div>

        {/* RELATED POSTS */}
        <SingleRelatedPosts relatedPosts={relatedPosts} />
      </div>
    </MainTemplate>
  );
};

export default ContentPage;
