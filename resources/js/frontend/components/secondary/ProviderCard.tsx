import { BPCA_MEMBER_LOGO } from '@/frontend/data/images';
import { InformationCircleIcon, PhoneIcon } from '@heroicons/react/solid';
import React from 'react';
import { Image } from '../primary/Image';

interface ProviderCardProps {
    /**
     * Provider name
     */
    name: string;
    /**
     * Provider logo
     */
    logo: string;
    /**
     * Provider address
     */
    address: string;
    /**
     * Show provider details handler
     */
    onShowDetails: () => void;
    /**
     * Call provider handler
     */
    onCall: () => void;
    /**
     * Year of accreditation
     */
    accredited?: string;
    /**
     * List of features
     */
    features?: string[];
    fallbackLogo: string;
}

export const ProviderCard: React.FC<ProviderCardProps> = ({
    name,
    logo,
    address,
    accredited,
    features = [],
    onShowDetails,
    onCall,
    fallbackLogo,
    ...props
}) => {
    return (
        <div
            className="flex flex-col w-full bg-white rounded-md border"
            {...props}
        >
            <div
                className="flex 
                flex-row sm:flex-row md:flex-col-reverse lg:flex-col-reverse
                justify-between p-4"
            >
                <div
                    className="basis-3/4 lg:basis-1 md:basis-1 sm:basis-3/4
                    flex flex-col 
                    items-start lg:items-center md:items-center sm:items-start
                    justify-center"
                >
                    <h2
                        className="text-xs font-semibold
                        text-left lg:text-center md:text-center sm:text-left
                        leading-5"
                    >
                        {name}
                    </h2>
                    <p
                        className="text-xs text-gray-400
                        text-left lg:text-center md:text-center sm:text-left
                        leading-5"
                    >
                        {address}
                    </p>
                </div>
                <div
                    className="basis-1/4 lg:basis-1 md:basis-1 sm:basis-1/4
                    flex flex-col 
                    items-end lg:items-center md:items-center sm:items-end
                    pb-0 lg:pb-2 md:pb-2 sm:pb-0
                    justify-center"
                >
                    <Image
                        fallbackSrc={fallbackLogo}
                        src={logo}
                        alt={name}
                        className="w-28 h-auto overflow-hidden"
                    />
                </div>
            </div>
            {accredited && (
                <p className="text-pest-rose text-center text-xs mb-2">
                    ACCREDITED SINCE {accredited}
                </p>
            )}
            {features && (
                <div className="text-center mb-4">
                    {features.map((feature, index) => (
                        <p
                            key={index}
                            className="text-[0.65rem] bg-pest-badge-lightpink rounded-xl inline-block m-1 py-1 px-2"
                        >
                            {feature}
                        </p>
                    ))}
                </div>
            )}
            <div className="flex flex-row items-center justify-center border-t">
                <button
                    className="w-full mx-auto my-auto h-10 rounded-l-md font-medium border-r text-gray-700 text-xs items-center flex justify-center"
                    onClick={onShowDetails}
                >
                    <InformationCircleIcon className="h-5 w-5 mr-2 fill-pest-icon-purple" />
                    Details
                </button>
                <button
                    className="w-full mx-auto my-auto h-10 rounded-md font-medium text-gray-700 text-xs items-center flex justify-center"
                    onClick={onCall}
                >
                    <PhoneIcon className="h-5 w-5 mr-2 fill-pest-icon-purple" />
                    Call
                </button>
            </div>
        </div>
    );
}
