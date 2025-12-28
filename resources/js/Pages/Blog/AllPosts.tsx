import React, { FC } from "react";
import ModalCategories from "@blog/containers/PageArchive/ModalCategories";
import { PostDataType, TaxonomyType } from "@blog/data/types";
import Pagination from "@blog/components/Pagination/Pagination";
import NcImage from "@blog/components/NcImage/NcImage";
import Card11 from "@blog/components/Card11/Card11";
import { Head } from "@inertiajs/inertia-react";
import MainTemplate from "./Template/MainTemplate";

export interface PageArchiveProps {
    className?: string;
    title?: string;
    posts: PostDataType[];
    category: TaxonomyType;
    categories: TaxonomyType[];
}

const CategoryPage: FC<PageArchiveProps> = ({ 
    className = "",
    title = "Category",
    posts = [],
    category,
    categories
}) => {
    return (
        <MainTemplate>
            <div
                className={`nc-PageArchive overflow-hidden ${className}`}
                data-nc-id="PageArchive"
            >
                <Head title={title} />

                {/* HEADER */}
                <div className="w-full px-2 xl:max-w-screen-2xl mx-auto">
                    <div className="rounded relative aspect-w-16 aspect-h-13 sm:aspect-h-9 lg:aspect-h-8 xl:aspect-h-5 overflow-hidden ">
                        {/* <NcImage
                            containerClassName="absolute inset-0"
                            // src={category.image}
                            className="object-cover w-full h-full"
                        /> */}
                        <div className="absolute inset-0 bg-gray-100 text-pest-rose flex flex-col items-center justify-center">
                            <h2 className="inline-block align-middle text-5xl font-semibold md:text-7xl ">
                                {/* {category.name} */}
                                All Posts
                            </h2>
                            <span className="block mt-4 text-neutral-400">
                                {category.count} Articles
                            </span>
                        </div>
                    </div>
                </div>
                {/* ====================== END HEADER ====================== */}

                <div className="container py-16 lg:pb-28 lg:pt-20 space-y-16 lg:space-y-28">
                    <div>
                        <div className="flex flex-col sm:items-center sm:justify-between sm:flex-row">
                            {/* <div className="flex space-x-2.5">
                                <ModalCategories categories={categories} />
                            </div> */}
                            <div className="block my-4 border-b w-full border-neutral-100 sm:hidden"></div>
                            <div className="flex justify-end">
                                {/* <ArchiveFilterListBox lists={FILTERS} /> */}
                            </div>
                        </div>

                        {/* LOOP ITEMS */}
                        <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 mt-8 lg:mt-10">
                            {posts && posts.map((post) => (
                                <Card11 key={post.id} post={post} />
                            ))}
                        </div>

                        {/* PAGINATIONS */}
                        <div className="flex opacity-10 flex-col mt-12 lg:mt-16 space-y-5 sm:space-y-0 sm:space-x-3 sm:flex-row sm:justify-end sm:items-center">
                            {/* <Pagination /> */}
                        </div>
                    </div>
                </div>
            </div>
        </MainTemplate>
    );
};

export default CategoryPage;
