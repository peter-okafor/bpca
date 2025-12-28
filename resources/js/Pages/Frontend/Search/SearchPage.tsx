import { LinkType, LocalityType } from '@/frontend/data/models';
import { ProviderInterface } from '@/frontend/data/ProviderInterface';
import { ArticleSection, Marker, PestSVG, ShowMapButton, SmallAtoZBanner } from '@frontend/components';
import { Map, PestsByLocation, ProviderList } from '@frontend/sections';
import { SearchTemplate } from '@frontend/templates';
import { Status, Wrapper } from '@googlemaps/react-wrapper';
import { Head } from '@inertiajs/inertia-react';
import parse from 'html-react-parser';
import { FC, useState } from 'react';


const render = (status: Status) => {
    return <h1>{status}</h1>;
};

interface SearchPageProps {
    paginator: {
        data: ProviderInterface[];

        current_page: number;

        per_page: number;

        total: number;
    };

    pest: {
        name: string;

        code: string;

        description: string;
    };

    postcode: string;

    footer: LinkType[];

    city: LocalityType;

    sublocalities: LinkType[];
    postCodeError: boolean;
    fallbackLogo: string;
}

const SearchPage: FC<SearchPageProps> = ({
    paginator,
    pest,
    postcode,
    footer,
    city,
    sublocalities,
    postCodeError,
    fallbackLogo = "",
}) => {
    const [showMap, setShowMap] = useState<boolean>(false);

    const { data, current_page, per_page, total } = paginator;

    return (
        <>
            <Head
                title={
                    pest && postcode
                        ? `${pest?.name} in ${postcode}`
                        : "Providers"
                }
            />
            <SearchTemplate
                postCodeError={postCodeError}
                showMap={showMap}
                setShowMap={setShowMap}
                footer={footer}
                defaultPest={pest?.name}
                defaultPostcode={postcode}
                defaultOpen={false}
            >
                <>
                    <div
                        className="py-6
                        lg:hidden md:hidden sm:block block"
                    >
                        <ShowMapButton
                            onClick={(e) => {
                                setShowMap(!showMap);
                            }}
                            label={showMap ? "Hide Map" : "Show Map"}
                        />
                    </div>
                    {showMap ? (
                        <Wrapper
                            apiKey={process.env.MIX_GOOGLE_MAPS_KEY as string}
                            render={render}
                        >
                            <Map className={`w-full h-80`}>
                                {data.map((provider, i) => (
                                    <Marker
                                        key={i}
                                        position={{
                                            lat: provider.geodata
                                                .coordinates[0],
                                            lng: provider.geodata
                                                .coordinates[1],
                                        }}
                                    />
                                ))}
                            </Map>
                        </Wrapper>
                    ) : (
                        <div></div>
                    )}
                    <ProviderList
                        fallbackLogo={fallbackLogo}
                        providers={data}
                        currentPage={current_page}
                        pageSize={per_page}
                        total={total}
                    />
                    <div
                        className="py-6 grid gap-x-10
                        px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm 
                        grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 md:grid-cols-2"
                    >
                        <ArticleSection
                            title={city?.name || "City"}
                            className="py-6 my-6 px-10 col-span-1"
                        >
                            <>
                                <p className="mb-7">
                                    {city?.description || ""}
                                </p>
                                <ShowMapButton
                                    onClick={(e) => {
                                        setShowMap(!showMap);
                                    }}
                                    label={showMap ? "Hide Map" : "Show Map"}
                                />
                            </>
                        </ArticleSection>

                        {pest && (
                            <ArticleSection
                                title={pest?.name}
                                className="py-6 my-6 px-10 col-span-1"
                            >
                                <div className="flex flex-col">
                                    <div className="flex flex-col pb-7">
                                        <div className="flex flex-row items-center mb-4">
                                            <PestSVG
                                                pest={pest?.name}
                                                fallbackSrc="https://via.placeholder.com/300x200"
                                                alt="pest"
                                                className="w-12 mr-4"
                                            />
                                            <h3 className="font-semibold">
                                                {pest?.name}
                                            </h3>
                                        </div>
                                        <span>{parse(pest.description)}</span>
                                    </div>
                                    <SmallAtoZBanner />
                                </div>
                            </ArticleSection>
                        )}
                    </div>

                    <PestsByLocation location={sublocalities} />
                </>
            </SearchTemplate>
        </>
    );
};

export default SearchPage