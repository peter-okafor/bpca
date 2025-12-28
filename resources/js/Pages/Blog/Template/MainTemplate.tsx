import React from "react";
// import { Helmet } from "react-helmet";
import HeaderContainer from "@blog/containers/HeaderContainer/HeaderContainer";
import MediaRunningContainer from "@blog/containers/MediaRunningContainer/MediaRunningContainer";
import Footer from "@/blog/components/Footer/Footer";


interface MainTemplateProps {
    children: React.ReactNode
}

const MainTemplate: React.FC<MainTemplateProps> = ({
    children
}) => {
    return (
        <div className="bg-white text-base dark:bg-neutral-900 text-neutral-900 dark:text-neutral-200">
            <MediaRunningContainer />

            {/* <ScrollToTop /> */}
            <HeaderContainer />
            {children}
            <Footer />
        </div>
    );
};

export default MainTemplate;
