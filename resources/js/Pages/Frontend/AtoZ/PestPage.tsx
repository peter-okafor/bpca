import { PoweredSection } from "@/frontend/components";
import { LinkType } from "@/frontend/data/models";
import { PestInterface, ProviderInterface } from "@/frontend/data/ProviderInterface";
import { Footer, Header, PestHeaderSection, PestDetail, PestPageMain } from "@/frontend/sections";
import React, { FC } from "react";

interface PestPageProps {
    pest: PestInterface;
    pestImage: string;
    content: string;
    topSearchedAreas: string[];
    pestControllers: ProviderInterface[];
    fallbackLogo: string;
    footer: LinkType[];
    imageUrl: string;
}

const PestPage: FC<PestPageProps> = ({
    pest,
    pestImage = "",
    content = "",
    topSearchedAreas = [],
    pestControllers = [],
    fallbackLogo = "",
    footer,
    imageUrl
}) => {
    return (
        <>
            <div className="w-full px-3.5 lg:px-0">
                <Header />
                <PestHeaderSection />
                <PestDetail
                    imageUrl={imageUrl}
                    pest={pest}
                    pestImage={pestImage}
                />
                <PestPageMain
                    content={content}
                    topSearchedAreas={topSearchedAreas}
                    pestControllers={pestControllers}
                    pest={pest}
                    fallbackLogo={fallbackLogo}
                />
            </div>
            <Footer items={footer} />
            <PoweredSection imageUrl={imageUrl} />
        </>
    );
};

export default PestPage