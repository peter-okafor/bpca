import { Inertia } from "@inertiajs/inertia";
import { FC, HtmlHTMLAttributes } from "react";
import { AtoZArticleSection, ProviderCard } from "../components";
import { ProviderInterface } from "../data/ProviderInterface";

interface RelatedPestControllersProps
    extends HtmlHTMLAttributes<HTMLDivElement> {
    pestName: string;
    pestControllers: ProviderInterface[];
    fallbackLogo: string;
}

export const RelatedPestControllers: FC<RelatedPestControllersProps> = ({
    pestName,
    pestControllers = [],
    fallbackLogo,
    className,
    ...props
}) => {
    const makeCall = (phoneNumber: string) => window.open(`tel:${phoneNumber}`, '_self');

    const getDetail = (provider: ProviderInterface) => {
        // Inertia.visit(`/details/${provider.name}`);
        window.location.href = `/details/${provider.name}`;
    }

    return (
        <AtoZArticleSection
            title={`Pest controllers that deal with ${pestName}`}
            titleColor="black"
            className={className}
            {...props}
        >
            <div className="grid gap-8">
                {pestControllers.map((provider, i) => (
                    <ProviderCard
                        key={i}
                        name={provider.name}
                        address={`${provider.address_1}, ${provider.address_2} ${provider.postcode}`}
                        features={provider.features}
                        fallbackLogo={fallbackLogo}
                        logo={provider.logo_url}
                        onCall={() => makeCall(provider.telephone)}
                        onShowDetails={() => getDetail(provider)}
                    />
                ))}
            </div>
        </AtoZArticleSection>
    );
}