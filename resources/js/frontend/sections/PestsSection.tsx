import { Inertia } from "@inertiajs/inertia";
import { FC, HTMLAttributes } from "react"
import { PestCard } from "../components";
import { PestInterface } from "../data/ProviderInterface";

interface PestsSectionProps extends HTMLAttributes<HTMLElement> {
    pests: { string: PestInterface[] };
    imageUrl: string;
}

export const PestsSection: FC<PestsSectionProps> = ({
    pests = [],
    imageUrl,
    ...props
}) => (
    <section
        className={`
                w-full 
                bg-pest-aliceblue 
                rounded-md 
                px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm 
                py-16
                justify-between
            `}
        {...props}
    >
        {Object.keys(pests).map((alphabet, i) => (
            <>
                <h2
                    className="text-3xl font-semibold my-4 mx-1 text-[#2F1C39]"
                    key={i}
                >
                    {alphabet}
                </h2>
                <div
                    className={`
                    grid
                    lg:grid-cols-3 md:grid-cols-2 grid-cols-1 
                    bg-white
                    rounded-md
                    px-2
                    gap-y-2
                `}
                >
                    {pests[alphabet].map((pest, i) => (
                        <PestCard
                            key={i}
                            pest={pest}
                            imageUrl={imageUrl}
                            className={"my-3 cursor-pointer"}
                            onClick={() => {
                                Inertia.visit(`/pests/${pest.name}`);
                            }}
                        />
                    ))}
                </div>
            </>
        ))}
    </section>
);


