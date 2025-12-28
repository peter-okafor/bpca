import api from '@/frontend/api';
import { PoweredSection } from '@/frontend/components';
import { ComponentContentType, LinkType, pestGroup } from '@/frontend/data/models';
import { PestInterface } from '@/frontend/data/ProviderInterface';
import { Footer, Header, PestSearchSection, PestsSection, PopularSearchesSection } from '@/frontend/sections';
import React, { FC, useEffect, useState } from 'react';

interface AtoZProps {
    pests: { string: PestInterface[] };
    footer: LinkType[];
    description: ComponentContentType;
    mostSearchedPests: [{}];
    imageUrl: string;
}

const AtoZ: FC<AtoZProps> = ({
    pests,
    footer,
    description,
    mostSearchedPests,
    imageUrl
}) => {
    const [pestHolder, setPestHolder] = useState<pestGroup>();

    useEffect(() => {
        setPestHolder(pests);
    }, [pests]);

    const search = (pest: string, environment: string, keyword: string, firstAlphabet: string) => {
        api.get('pest/filter', {
            params: {
                pest: pest || undefined,
                environment: environment || undefined,
                keyword: keyword || undefined,
                firstAlphabet: firstAlphabet || undefined
            }
        }).then(data => {
            if (data.status === 200) {
                setPestHolder(data.data.pests as pestGroup)
            }
        })
    }

    const reset = () => {
        setPestHolder(pests)
    }

    return (
        <>
            <div className="w-full px-3.5 lg:px-0">
                <Header />
                <PestSearchSection
                    pests={pests}
                    search={search}
                    reset={reset}
                    description={description}
                />
                <PestsSection
                    imageUrl={imageUrl}
                    pests={pestHolder as pestGroup}
                />
                <PopularSearchesSection
                    className="mt-10 lg:mt-0"
                    popularPests={mostSearchedPests}
                />
            </div>
            <div className="bg-pest-cyprus px-4 py-16 lg:py-24 lg:px-[14.5%] flex items-center justify-between">
                <Footer items={footer} />
                <PoweredSection imageUrl={imageUrl} />
            </div>
        </>
    );

}

export default AtoZ