import { FC } from "react";

interface TrustCardProps {
    title: string;
    description: string;
    author: string;
    image: string;
    className?: string;
}

export const TrustCard: FC<TrustCardProps> = ({
    title,
    description,
    author,
    image,
    className
}) => {
    return (
        <div className={`h-pestcard ${className} px-2`}>
            <div
                style={{
                    backgroundImage: `url(${process.env.MIX_APP_AWS_S3}${image})`,
                }}
                className="w-full bg-cover bg-center bg-no-repeat bg-black h-1/3 rounded-sm"
            ></div>
            <div className="bg-pest-aliceblue p-[7%] space-y-6 h-full px-8">
                <h3 className="font-semibold text-2xl text-black">
                    {title}
                </h3>
                <p className="font-semibold text-black leading-6">
                    {description}
                </p>
                <p className="font-semibold text-gray-400 text-xs">
                    {author}
                </p>
            </div>
        </div>
    );
}