import React, { FC } from "react";
import WidgetAuthors from "../../components/WidgetAuthors/WidgetAuthors";
import WidgetCategories from "../../components/WidgetCategories/WidgetCategories";
import WidgetPosts from "../../components/WidgetPosts/WidgetPosts";
import { DEMO_AUTHORS } from "../../data/authors";
import { DEMO_POSTS } from "../../data/posts";
import { DEMO_CATEGORIES, DEMO_TAGS } from "../../data/taxonomies";
import { PostDataType, TaxonomyType } from "../../data/types";

export interface SidebarProps {
  className?: string;
  categories?: TaxonomyType[];
  posts?: PostDataType[];
}

export const Sidebar: FC<SidebarProps> = ({
    className = "space-y-6 ",
    categories,
    posts
}) => {
  return (
    <div className={`nc-SingleSidebar ${className}`}>
      {categories && (
        <WidgetCategories categories={categories} />
      )}
      {posts && (
        <WidgetPosts posts={posts} />
      )}
    </div>
  );
};
