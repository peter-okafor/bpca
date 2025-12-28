import { ProviderContact, Tabs } from '@frontend/sections';
import { SearchTemplate } from '@frontend/templates/SearchTemplate';
import { FC } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { ProviderInterface } from '@/frontend/data/ProviderInterface';
import { AtoZBanner, LabelledText, PestCard } from '@/frontend/components';
import { Inertia } from '@inertiajs/inertia';
import { LinkType } from '@/frontend/data/models';

interface DetailsPageProps {
    provider: ProviderInterface;
    footer: LinkType[];
    postCodeError: boolean;
    imageUrl: string;
}

const DetailsPage: FC<DetailsPageProps> = ({
    provider,
    footer,
    postCodeError,
    imageUrl,
}) => {
    const { providerList } = usePage().props;

    const nextProviderName = (
        providers: ProviderInterface[],
        currentProvider: string
    ) => {
        const id = providers?.findIndex(
            (item) => item.name === currentProvider
        );
        return id + 1 < providers?.length ? providers[id + 1]?.name : "";
    };

    const prevProviderName = (
        providers: ProviderInterface[],
        currentProvider: string
    ) => {
        const id = providers?.findIndex(
            (item) => item.name === currentProvider
        );
        return id - 1 >= 0 ? providers[id - 1]?.name : "";
    };

    const nextPage = () => {
        const title = nextProviderName(
            providerList as ProviderInterface[],
            provider?.name
        );
        if (title) {
            Inertia.visit(`/details/${title}`);
        }
    };

    const prevPage = () => {
        const title = prevProviderName(
            providerList as ProviderInterface[],
            provider?.name
        );
        if (title) {
            Inertia.visit(`/details/${title}`);
        }
    };

    return (
        <>
            <Head title={provider?.name} />
            <SearchTemplate
                postCodeError={postCodeError}
                showMapButton={false}
                footer={footer}
            >
                <div
                    className="w-full grid py-4
                    grid-cols-1 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1
                    gap-x-10
                    bg-pest-aliceblue
                    px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm "
                >
                    <ProviderContact
                        className="col-span-1"
                        logo={provider.logo_url}
                        name={provider.name}
                        email={provider.email}
                        phone={provider.telephone}
                        website={provider.website}
                        accreditation_year={provider.accreditation_year}
                        features={provider.features}
                        onBackClick={prevPage}
                        onNextClick={nextPage}
                    />
                    <Tabs
                        className={
                            "col-span-1 lg:col-span-2 md:col-span-2 sm:col-span-1"
                        }
                        tabHeader={["Profile", "Services"]}
                    >
                        <div>
                            {provider.description && (
                                <LabelledText
                                    label="About"
                                    content={provider.description || ""}
                                />
                            )}
                            {(provider.town || provider.postcode) && (
                                <LabelledText
                                    label="Address"
                                    content={`${provider.town}${
                                        provider.postcode
                                            ? ", " + provider.postcode
                                            : ""
                                    }`}
                                    formatHtml={false}
                                />
                            )}
                            {provider.contact_hours && (
                                <LabelledText
                                    label="Opening hours"
                                    content={provider.contact_hours || ""}
                                    formatHtml={false}
                                />
                            )}
                            {provider.premises_type && (
                                <LabelledText
                                    label="Locations Covered"
                                    content={provider.premises_type || ""}
                                    formatHtml={false}
                                />
                            )}
                        </div>
                        <div>
                            <div className="grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
                                {provider.pests?.map((pest, index) => (
                                    <div key={index}>
                                        <PestCard
                                            imageUrl={imageUrl}
                                            pest={pest}
                                            className={"mt-6"}
                                        />
                                    </div>
                                ))}
                            </div>
                            <AtoZBanner className="h-28 mt-28" />
                        </div>
                    </Tabs>
                </div>
            </SearchTemplate>
        </>
    );
};

export default DetailsPage;