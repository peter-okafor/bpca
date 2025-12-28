import { FC, HtmlHTMLAttributes } from "react";
import { Image, PestCard } from "../components";
import { PestInterface } from "../data/ProviderInterface"
import parse from 'html-react-parser';

interface PestDetailProps extends HtmlHTMLAttributes<HTMLElement> {
    pest: PestInterface;
    pestImage: string;
    imageUrl: string;
}

export const PestDetail: FC<PestDetailProps> = ({
    pest,
    pestImage,
    className,
    imageUrl,
    ...props
}) => {
    return (
        <section
            className={`${className} lg:mb-20 mb-0 lg:mt-16 mt-4 grid lg:grid-cols-3 grid-cols-1 lg:px-container_lg gap-x-12`}
            {...props}
        >
            <div className="lg:col-span-2 col-span-1">
                <PestCard
                    imageUrl={imageUrl}
                    pest={pest}
                    className="lg:mb-12 mb-8 mt-4 text-[#112E51]"
                    size="big"
                />
                <p className="font-light hidden lg:block">
                    {parse(pest.description)}
                </p>
            </div>
            <div className="col-span-1">
                <Image src={pestImage} className="lg:mb-0 mb-9" />
                <p className="font-light lg:hidden block">{parse(pest.description)}</p>
            </div>
        </section>
    );
}