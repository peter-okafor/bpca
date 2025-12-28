import { FC, HTMLAttributes } from "react"
import { AtoZHeading, BackToSearch } from "../components";
import { PestInterface } from "../data/ProviderInterface";

interface PestSearchSectionProps extends HTMLAttributes<HTMLElement> {
    environments?: string[];
    pests?: {string: PestInterface[]};
}

export const PestHeaderSection: FC<PestSearchSectionProps> = ({
    className = '',
    environments = ['Both', 'Inside', 'Outside'],
    pests = [],
    ...props
}) => {
    return (
        <section
            className={`
                min-h-28
                h-fit
                w-full
                bg-atoz 
                bg-no-repeat 
                bg-center 
                bg-cover 
                bg-origin-border 
                px-4
                lg:px-container_lg
                pb-6
                lg:pb-8
                pt-8
                lg:pt-14
                rounded-lg
                lg:rounded-none
                ${className}
            `}
            {...props}
        >
            <div className={`
                grid
                grid-cols-1
                lg:grid-cols-2
                lg:mt-6
                gap-6
            `}>
                <AtoZHeading className="col-span-1">
                    A-Z of pests
                </AtoZHeading>
            </div>
            <div className={`
                mt-2
                lg:mt-4
            `}>
                <div className="text-right">
                    <BackToSearch/>
                </div>
            </div>
        </section>
    )
}


