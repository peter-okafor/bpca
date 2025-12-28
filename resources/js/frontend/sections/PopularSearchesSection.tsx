import { FC, HTMLAttributes } from "react"
import { PopularSearchItem } from "../components"

interface PopularSearchesSectionInterface extends HTMLAttributes<HTMLElement> {
    popularPests: [{}];
}

export const PopularSearchesSection: FC<PopularSearchesSectionInterface> = ({
    className,
    popularPests = [],
    ...props
}) => {
    return (
        <section
            className={`${className} bg-gradient-to-r from-pest-purple to-pest-rose px-4 py-10 mb-4 rounded-lg lg:px-[14.5%] lg:py-24 lg:mb-0 lg:rounded-none`}
            {...props}
        >
            <h3 className="font-semibold text-white text-3xl pb-10 text-left lg:text-center">
                Popular Searches
            </h3>
            <p className="text-white text-sm text-left w-full mx-auto pb-4 lg:text-center lg:w-2/5 lg:mx-auto lg:pb-20">
                Discover common pests in your area with our popular local search
                results.
            </p>
            <div className="grid gap-y-2 w-full lg:grid-cols-4 lg:gap-x-20">
                {popularPests &&
                    popularPests.map((pest) => (
                        <PopularSearchItem key={pest.id}>{`${pest?.service} in ${pest?.title}`}</PopularSearchItem>
                    ))}
            </div>
        </section>
    );
}