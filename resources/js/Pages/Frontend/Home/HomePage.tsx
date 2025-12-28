import { ComponentContentType, LinkType, ReviewType } from '@/frontend/data/models';
import { PoweredSection } from '@frontend/components';
import { Banner, Footer, Header, PestsByLocation, PopularSearchesSection, TrustBox, WantToJoin, WhyBox } from '@frontend/sections';
import { FC } from 'react';

interface HomePageProps {
    benefits: ComponentContentType;
    reviews: ReviewType[];
    footer: LinkType[];
    organisationCount: number;
    pestCount: number;
    searchAverage: number;
    countries: LinkType[];
    mostSearchedPests: [{}];
    postCodeError: boolean;
    imageUrl: string;
}
const HomePage: FC<HomePageProps> = ({
    benefits,
    reviews,
    footer,
    organisationCount,
    pestCount,
    searchAverage,
    countries,
    mostSearchedPests,
    postCodeError,
    imageUrl,
}) => {
    return (
        <>
            <div className="px-4 lg:px-0">
                <Header />
                <Banner
                    providerCount={organisationCount}
                    pestCount={pestCount}
                    searchCount={searchAverage}
                    postCodeError={postCodeError}
                />
                <WhyBox benefits={benefits} />
                <TrustBox reviews={reviews} />
                <WantToJoin />
                {/* <PestsByLocation location={countries} /> */}
                {/* {JSON.stringify(mostSearchedPests)} */}
                <PopularSearchesSection popularPests={mostSearchedPests} /> 

            </div>

            <div className="bg-pest-cyprus px-4 py-16 lg:py-24 lg:px-[14.5%] flex items-center justify-between">
                <Footer items={footer} />
                <PoweredSection imageUrl={imageUrl} />
            </div>
        </>
    );
};

export default HomePage;