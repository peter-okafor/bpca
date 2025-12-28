import { ComponentContentType, LinkType } from '@/frontend/data/models';
import { ArticleSection, PoweredSection } from '@frontend/components';
import { Footer, Header, SubHeader } from '@frontend/sections';
import { Head } from '@inertiajs/inertia-react';
import parse from 'html-react-parser';
import { FC } from 'react';

interface AboutPageProps {
    footer: LinkType[];
    about: ComponentContentType;
    imageUrl: string;
}

const AboutPage: FC<AboutPageProps> = ({
    footer,
    about,
    imageUrl
}) => {

    return (
        <>
            <Head title="About Us" />
            <Header />
            <SubHeader />
            <div className="lg:px-container_lg p-4 lg:bg-pest-aliceblue">
                <ArticleSection title="About Us" className="lg:bg-white">
                    <>{parse(about?.content)}</>
                </ArticleSection>
            </div>
            <div className="bg-pest-cyprus px-4 py-16 lg:py-24 lg:px-[14.5%] flex items-center justify-between">
                <Footer items={footer} />
                <PoweredSection imageUrl={imageUrl} />
            </div>
        </>
    );
}

export default AboutPage