import { FC } from "react";

interface StatisticBoxProps {
    title: string;
    value: string;
    color?: string;
    className?: string;
}

export const StatisticBox: FC<StatisticBoxProps> = ({
    title,
    value,
    color,
    className
}) => {
    return (
        <div
            className={`grid place-items-center pl-14 justify-start text-white ${className}`}
            style={{
                backgroundColor: color,
            }}
        >
            <div>
                <h3 className="font-bold text-4xl">{value}</h3>
                <p className="font-bold text-sm">{title}</p>
            </div>
        </div>
    );
}