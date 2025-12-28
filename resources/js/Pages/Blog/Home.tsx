import React from "react";
// import { Helmet } from "react-helmet";
import BgGlassmorphism from "@blog/components/BgGlassmorphism/BgGlassmorphism";
import SectionMagazine1 from "@blog/containers/PageHome/SectionMagazine1";
import SectionLargeSlider from "@blog/containers/PageHome/SectionLargeSlider";
import BackgroundSection from "@blog/components/BackgroundSection/BackgroundSection";
import { PostDataType, TaxonomyType } from "@blog/data/types";
import {
    DEMO_POSTS
} from "@blog/data/posts";
import SectionSliderNewCategories from "@blog/components/SectionSliderNewCategories/SectionSliderNewCategories";
import { Head } from "@inertiajs/inertia-react";
import MainTemplate from "./Template/MainTemplate";

interface HomeProps {
    latestPosts: PostDataType[];
    posts: PostDataType[];
    categories: TaxonomyType[];
}

const Home: React.FC<HomeProps> = ({
    latestPosts = [],
    posts = [],
    categories = []
}) => {
    return (
        <MainTemplate>
            <div className="nc-PageHome relative">
                <Head title="Blog" />

                {/* ======== ALL SECTIONS ======== */}
                <div className="relative overflow-hidden">
                    {/* ======== BG GLASS ======== */}
                    <BgGlassmorphism />

                    {/* ======= START CONTAINER ============= */}
                    <div className="container relative">
                        {/* === SECTION  === */}
                        <SectionLargeSlider
                            className="pt-10 pb-16 md:py-16 lg:pb-28 lg:pt-20"
                            posts={latestPosts}
                        />

                        {/* === SECTION  === */}
                        <div className="relative py-8">
                            <BackgroundSection />
                            <SectionSliderNewCategories
                                className="py-16 lg:py-28"
                                heading="Categories"
                                subHeading="Discover topics"
                                categories={categories}
                                categoryCardType="card4"
                                uniqueSliderClass="pageHome-section5"
                            />
                        </div>

                        {/* === SECTION 4 === */}
                        
                    </div>

                    {/* === SECTION 11 === */}
                    <div className="dark bg-neutral-900 dark:bg-black dark:bg-opacity-20 text-neutral-100 mt-12">
                        <div className="relative container">
                        <SectionMagazine1
                            className="py-16 lg:py-28"
                            posts={posts}
                            tabs={categories?.filter((_, i) => i >= 0 && i < 4).map(i => i.name)}
                        />
                        </div>
                    </div>
                    {/* ======= END CONTAINER ============= */}
                </div>
            </div>
        </MainTemplate>
    );
};

export default Home;
