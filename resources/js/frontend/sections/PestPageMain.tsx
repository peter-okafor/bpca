import { FC } from "react";
import { AtoZArticleSection } from "../components";
import { PestInterface, ProviderInterface } from "../data/ProviderInterface";
import { PestControllerSearch, RelatedPestControllers, TopPestSearchAreas } from "../widgets";
import parse from 'html-react-parser'

interface PestPageMainProps {
    pest: PestInterface;
    content: string;
    topSearchedAreas: string[];
    pestControllers: ProviderInterface[];
    fallbackLogo: string;
}

export const PestPageMain: FC<PestPageMainProps> = ({
    pest,
    content = "",
    topSearchedAreas = [],
    pestControllers = [],
    fallbackLogo,
}) => (
    <section className="w-full grid grid-cols-1 lg:grid-cols-3 gap-12 lg:bg-pest-aliceblue bg-white lg:px-container_lg lg:py-20 py-10">
        <PestControllerSearch
            pestName={pest.name}
            pestCode={pest.code}
            className="col-span-1 lg:hidden"
        />

        <AtoZArticleSection className="col-span-1 lg:col-span-2 bg-pest-aliceblue lg:bg-white">
            <>{parse(content)}</>
        </AtoZArticleSection>

        <div className="col-span-1 bg-transparent grid grid-cols-1 gap-7">
            <PestControllerSearch
                pestName={pest.name}
                pestCode={pest.code}
                className="lg:block hidden"
            />
            <TopPestSearchAreas
                pestName={pest.name}
                topAreas={topSearchedAreas}
                className="bg-pest-aliceblue lg:bg-white"
            />
            <RelatedPestControllers
                pestName={pest.name}
                pestControllers={pestControllers}
                fallbackLogo={fallbackLogo}
                className="bg-pest-aliceblue lg:bg-white"
            />
        </div>
    </section>
);