import { FC, HtmlHTMLAttributes } from "react";
import { AtoZArticleSection } from "../components";

interface TopPestSearchAreasProps extends HtmlHTMLAttributes<HTMLDivElement> {
    pestName: string;
    topAreas: string[];
}

export const TopPestSearchAreas: FC<TopPestSearchAreasProps> = ({
    pestName,
    topAreas = [],
    className,
    ...props
}) => {
    return (
        <AtoZArticleSection
            title={`Top search areas for ${pestName} in the UK`}
            titleColor={'black'}
            className={className}
            {...props}
        >
            <ol className="list-decimal list-inside text-[#CD325A] font-bold">
                {topAreas.map((location, i) => (
                    <li key={i}>
                        <span className="text-[#565656] px-2">{location}</span>
                    </li>
                ))}
            </ol>
        </AtoZArticleSection>
    );
}