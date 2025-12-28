import { ChevronDownIcon, ChevronRightIcon } from "@heroicons/react/solid";
import { FC, useState } from "react"
import { LocationLink } from "../components"
import { LinkType } from "../data/models"

interface PestsByLocationProps {
    location: LinkType[];
}

export const PestsByLocation: FC<PestsByLocationProps> = ({
    location
}) => {
    const [hide, setHide] = useState(false);

    const collapse = () => {
        setHide(!hide)
    }

    return location && location.length ? (
        <section className="bg-pest-aliceblue px-4 py-6 mb-4 lg:px-[14.5%] lg:py-24 lg:mb-0">
            <div
                onClick={collapse}
                className="inline-flex pt-4 pb-8 text-center cursor-pointer"
            >
                <h3 className="font-semibold text-2xl text-black">
                    Providers By Location
                </h3>
                {hide ? (
                    <ChevronDownIcon className="w-5 ml-2 h-auto" />
                ) : (
                    <ChevronRightIcon className="w-5 ml-2 h-auto" />
                )}
            </div>
            {hide && (
                <div className="grid grid-cols-1 lg:grid-cols-4 pt-4">
                    {location &&
                        location.map((child, index) => (
                            <a
                                key={index}
                                href={child.link}
                                className="text-center"
                            >
                                <LocationLink>{child.item}</LocationLink>
                            </a>
                        ))}
                </div>
            )}
        </section>
    ) : (
        <></>
    );
}