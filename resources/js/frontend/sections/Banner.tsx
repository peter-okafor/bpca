import { Inertia } from "@inertiajs/inertia";
import { FC } from "react";
import { StatisticBox } from "../components";
import { Search } from "./Search";

interface BannerProps {
    providerCount: number;
    searchCount: number;
    pestCount: number;
    postCodeError: boolean;
}

export const Banner: FC<BannerProps> = ({
    providerCount,
    searchCount,
    pestCount,
    postCodeError
}) => {
    return (
        <div className="grid min-h-[480px] h-fit w-full grid-cols-1 mb-8 lg:grid-cols-5 lg:mb-0">
            <div className="md:bg-right-0 h-inherit bg-gradient-to-r from-pest-purple to-pink-700 px-4 rounded-lg mb-8 pt-4 lg:col-span-4 lg:pl-[18%] lg:rounded-none lg:mb-0 lg:pt-12 bg-banner bg-no-repeat bg-right-4 md:bg-right lg:bg-origin-padding bg-cover lg:bg-contain">
                <Search
                    width={`md:w-3/4`}
                    postCodeError={postCodeError}
                    className="pb-16 pt-12 text-white max-w-xl mx-auto lg:mx-0"
                />
            </div>
            <div className="h-full rounded-lg overflow-hidden lg:rounded-none">
                <StatisticBox
                    title="Registered pest controllers"
                    value={providerCount.toLocaleString("en-US")}
                    className="md:h-1/3 py-6 md:py-0 bg-pest-rose"
                />
                <StatisticBox
                    title="Searches per day"
                    value={searchCount.toLocaleString("en-US")}
                    className="md:h-1/3 py-6 md:py-0 bg-pest-violet"
                />
                <StatisticBox
                    title="Pests Covered"
                    value={pestCount.toLocaleString("en-US")}
                    className="md:h-1/3 py-6 md:py-0 bg-pest-purple"
                />
            </div>
        </div>
    );
}